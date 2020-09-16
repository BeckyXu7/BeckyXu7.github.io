am4core.useTheme(am4themes_animated);

var visitchart = am4core.create("visit_chart", am4charts.XYChart);
var purchasechart = am4core.create("purchase_chart", am4charts.XYChart);
var convertchart = am4core.create("convert_chart", am4charts.XYChart);
var staychart = am4core.create("stay_chart", am4charts.XYChart);
var purchase_staychart = am4core.create("purchase_stay_chart", am4charts.XYChart);
$(document).ready(function () {
    $.ajax({
        url: 'getData.php',
        type: 'POST',
        data: {'type': 'visit'},
        success: function(data){
            visitchart.data = eval("("+data+")");
        }
    })
    $.ajax({
        url: 'getData.php',
        type: 'POST',
        data: {'type': 'purchase'},
        success: function(data){
            purchasechart.data = eval("("+data+")");
        }
    })
    $.ajax({
        url: 'getData.php',
        type: 'POST',
        data: {'type': 'total_stay'},
        success: function(data){
            staychart.data = eval("("+data+")");
        }
    })
    $.ajax({
        url: 'getData.php',
        type: 'POST',
        data: {'type': 'purchase_stay'},
        success: function(data){
            purchase_staychart.data = eval("("+data+")");
        }
    })

    $.ajax({
        url: 'getData.php',
        type: 'POST',
        data: {'type': 'convert_ratio'},
        success: function(data){
            convertchart.data = eval("("+data+")");
        }
    })

    $.ajax({
        url: 'getData.php',
        type: 'POST',
        data: {'type': 'purchase_info',
                'limit': 'day'},
        success: function(data){
            document.getElementById('purchaseHistory').innerHTML = data;
        }
    })
})

function displaytPurchase(limit) {
    if(limit=="all"){
        $.ajax({
            url: 'getData.php',
            type: 'POST',
            data: {'type': 'purchase_info',
                    'limit': 'all'},
            success: function(data){
                document.getElementById('purchaseHistory').innerHTML = data;
            }
        })
    } else {
        $.ajax({
            url: 'getData.php',
            type: 'POST',
            data: {'type': 'purchase_info',
                    'limit': 'day'},
            success: function(data){
                document.getElementById('purchaseHistory').innerHTML = data;
            }
        })
    }
}



var categoryAxis1 = visitchart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis1.title.text = "Date";
categoryAxis1.title.fontWeight = "bold";
categoryAxis1.renderer.grid.template.location = 0;
categoryAxis1.dataFields.category = "date";
categoryAxis1.renderer.minGridDistance = 60;
var valueAxis1 = visitchart.yAxes.push(new am4charts.ValueAxis());
valueAxis1.title.text = "Visits";
valueAxis1.title.fontWeight = "bold";
valueAxis1.min = 0;
valueAxis1.strictMinMax = true;
valueAxis1.renderer.minGridDistance = 30;
valueAxis1.renderer.labels.template.hiddenState.transitionDuration = 2000;
valueAxis1.renderer.labels.template.defaultState.transitionDuration = 2000;
var series1 = visitchart.series.push(new am4charts.ColumnSeries());
series1.dataFields.categoryX = "date";
series1.dataFields.valueY = "visits";
series1.columns.template.tooltipText = "{valueY.value}";
series1.columns.template.tooltipY = 0;
series1.columns.template.strokeOpacity = 0;
// as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
series1.columns.template.adapter.add("fill", function (fill, target) {
	return visitchart.colors.getIndex(target.dataItem.index);
});

//chart2.padding(40, 40, 40, 40);

var categoryAxis2 = purchasechart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis2.title.text = "Date";
categoryAxis2.title.fontWeight = "bold";
categoryAxis2.renderer.grid.template.location = 0;
categoryAxis2.dataFields.category = "date";
categoryAxis2.renderer.minGridDistance = 60;
var valueAxis2 = purchasechart.yAxes.push(new am4charts.ValueAxis());
valueAxis2.title.text = "Orders";
valueAxis2.title.fontWeight = "bold";
valueAxis2.min = 0;
valueAxis2.strictMinMax = true;
valueAxis2.renderer.minGridDistance = 30;
valueAxis2.renderer.labels.template.hiddenState.transitionDuration = 2000;
valueAxis2.renderer.labels.template.defaultState.transitionDuration = 2000;
var series2 = purchasechart.series.push(new am4charts.ColumnSeries());
series2.dataFields.categoryX = "date";
series2.dataFields.valueY = "purchase";
series2.columns.template.tooltipText = "{valueY.value}";
series2.columns.template.tooltipY = 0;
series2.columns.template.strokeOpacity = 0;
// as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
series2.columns.template.adapter.add("fill", function (fill, target) {
	return purchasechart.colors.getIndex(target.dataItem.index);
});

var categoryAxis3 = staychart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis3.title.text = "Date";
categoryAxis3.title.fontWeight = "bold";
categoryAxis3.renderer.grid.template.location = 0;
categoryAxis3.dataFields.category = "date";
categoryAxis3.renderer.minGridDistance = 60;
var valueAxis3 = staychart.yAxes.push(new am4charts.ValueAxis());
valueAxis3.title.text = "Average Time on Site (Seconds)";
valueAxis3.title.fontWeight = "bold";
valueAxis3.min = 0;
valueAxis3.strictMinMax = true;
valueAxis3.renderer.minGridDistance = 30;
valueAxis3.renderer.labels.template.hiddenState.transitionDuration = 2000;
valueAxis3.renderer.labels.template.defaultState.transitionDuration = 2000;
var series3 = staychart.series.push(new am4charts.ColumnSeries());
series3.dataFields.categoryX = "date";
series3.dataFields.valueY = "staytime";
series3.columns.template.tooltipText = "{valueY.value}";
series3.columns.template.tooltipY = 0;
series3.columns.template.strokeOpacity = 0;
// as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
series3.columns.template.adapter.add("fill", function (fill, target) {
	return staychart.colors.getIndex(target.dataItem.index);
});

var categoryAxis4 = purchase_staychart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis4.title.text = "Date";
categoryAxis4.title.fontWeight = "bold";
categoryAxis4.renderer.grid.template.location = 0;
categoryAxis4.dataFields.category = "date";
categoryAxis4.renderer.minGridDistance = 60;
var valueAxis4 = purchase_staychart.yAxes.push(new am4charts.ValueAxis());
valueAxis4.title.text = "Average Time on Site (Seconds)";
valueAxis4.title.fontWeight = "bold";
valueAxis4.min = 0;
valueAxis4.strictMinMax = true;
valueAxis4.renderer.minGridDistance = 30;
valueAxis4.renderer.labels.template.hiddenState.transitionDuration = 2000;
valueAxis4.renderer.labels.template.defaultState.transitionDuration = 2000;
var series4 = purchase_staychart.series.push(new am4charts.ColumnSeries());
series4.dataFields.categoryX = "date";
series4.dataFields.valueY = "staytime";
series4.columns.template.tooltipText = "{valueY.value}";
series4.columns.template.tooltipY = 0;
series4.columns.template.strokeOpacity = 0;
// as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
series4.columns.template.adapter.add("fill", function (fill, target) {
	return purchase_staychart.colors.getIndex(target.dataItem.index);
});

var categoryAxis5 = convertchart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis5.title.text = "Date";
categoryAxis5.title.fontWeight = "bold";
categoryAxis5.renderer.grid.template.location = 0;
categoryAxis5.dataFields.category = "date";
categoryAxis5.renderer.minGridDistance = 60;
var valueAxis5 = convertchart.yAxes.push(new am4charts.ValueAxis());
valueAxis5.title.text = "Convert Ratio";
valueAxis5.title.fontWeight = "bold";
valueAxis5.min = 0;
valueAxis5.max = 1;
valueAxis5.strictMinMax = true;
valueAxis5.renderer.minGridDistance = 30;
valueAxis5.renderer.labels.template.hiddenState.transitionDuration = 2000;
valueAxis5.renderer.labels.template.defaultState.transitionDuration = 2000;
var series5 = convertchart.series.push(new am4charts.ColumnSeries());
series5.dataFields.categoryX = "date";
series5.dataFields.valueY = "convert";
series5.columns.template.tooltipText = "{valueY.value}";
series5.columns.template.tooltipY = 0;
series5.columns.template.strokeOpacity = 0;
// as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
series5.columns.template.adapter.add("fill", function (fill, target) {
	return convertchart.colors.getIndex(target.dataItem.index);
});