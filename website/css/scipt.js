
			function addCourse(user_course_code, user_semester, user_mode){
				console.log("add");
				//$("p").append(" <b>Hello world!</b>");
				$.ajax({
					type: "POST",
					url: "uq_ass.php",
					data: { 
						course_code: user_course_code,
						 semester: user_semester,
						  mode: user_mode
					},
					dataType: 'json',
					success: function(result) {
						$('#assessments').append(result);
					}
				});
			}

			function makeTableEditable(type, index) {
				var textOnButton = document.getElementById("task1");
				console.log(document.getElementsByClassName("task"));
				console.log(document.getElementsByClassName("date"));
				if (type == "task") {
					var task = document.getElementsByClassName("task");
				} else {
					var date = document.getElementsByClassName("date");
				}
				
				
				if (textOnButton.value == "Edit") {
					if (type == "task") {
					task[index].contentEditable = true;
				} else {
					date[index].contentEditable = true;
				}
					document.getElementById("editMessage").innerHTML = "You can edit assessment task and due date now";
					textOnButton.value = "Save";
				} else if (textOnButton.value == "Save") {
					if (type == "task") {
					task[index].contentEditable = false;
				} else {
					date[index].contentEditable = false;
				}
					textOnButton.value = "Edit";
					document.getElementById("editMessage").innerHTML = "";
		
				}
			}
