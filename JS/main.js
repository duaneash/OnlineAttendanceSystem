// Form validation
let loginForm = document.getElementById('loginForm');
let registerForm = document.getElementById('registerForm');
let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
let passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;

function validateForm(form) {
    let email = form.elements['email'].value;
    let password = form.elements['password'].value;
    let isValid = true;
    let message = "";

    if (!emailRegex.test(email)) {
        isValid = false;
        message = "Invalid email format.";
    } else if (!passwordRegex.test(password)) {
        isValid = false;
        message = "Password must be at least 8 characters and include a digit, a lowercase letter, and an uppercase letter.";
    }

    if (!isValid) {
        event.preventDefault();
        alert(message);
    }
}

if (loginForm) {
    loginForm.addEventListener('submit', function(event) {
        validateForm(loginForm);
    });
}

if (registerForm) {
    registerForm.addEventListener('submit', function(event) {
        validateForm(registerForm);
    });
}

// Inline editing for course names
let courseNames = document.getElementsByClassName('course-name');

for (let i = 0; i < courseNames.length; i++) {
    let courseName = courseNames[i];
    
    courseName.addEventListener('click', function() {
        let courseId = courseName.getAttribute('data-course-id');
        let originalName = courseName.textContent;
        let input = document.createElement('input');
        
        input.value = originalName;
        courseName.textContent = '';
        courseName.appendChild(input);
        input.focus();
        
        input.addEventListener('blur', function() {
            let newName = input.value;
            courseName.textContent = newName;

            // Send the new course name to the server
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'process_teacher.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('course_id=' + courseId + '&update_course=' + newName);
        });
        
        input.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                input.blur();
            }
        });
    });
}

$(document).ready(function() {
    // Other script code...
	$('.list-group-item').on('click', function() {
		var option = $(this).data('option');
		$('.option-content').hide();
		$('#' + option).show();
		if (option == 'view') {
			$('#courseInfo').hide();
			$('#attendance-info').show();
		} else {
			$('#courseInfo').show();
			$('#attendance-info').hide();
		}
	});

	// When the view attendance form is submitted, prevent its default action and send an AJAX request
	$('#attendance-form').on('submit', function(e) {
		e.preventDefault();

		var url = 'process_teacher.php';
		var data = $(this).serialize() + "&view_attendance=true";

		$.post(url, data, function(response) {
			$('#courseInfo').hide();
			$('#attendance-info').show();

			var records = JSON.parse(response);
			var rows = '';
			$.each(records, function(index, record) {
				rows += '<tr><td>' + record.name + '</td><td>' + record.status + '</td><td>' + record.date + '</td></tr>';
			});
			$('#attendance-table tbody').html(rows);
		});
	});
    // Update registration link based on user type selection
    $('#userType').on('change', function() {
        if (this.value === 'teacher') {
            $('#signupLink').attr('href', 'teacher_signup.php');
        } else if (this.value === 'student') {
            $('#signupLink').attr('href', 'student_signup.php');
        } else {
            $('#signupLink').attr('href', '#');
        }
    });

	$('.list-group-item').on('click', function() {
		var option = $(this).data('option');
		$('.option-content').hide();
		$('#' + option).show();
	});

	$('#viewAttendanceButton').on('click', function() {
		var courseId = $('#courseIdView').val();

		$.ajax({
			url: 'process_student.php',
			type: 'POST',
			data: {view_attendance: 'true', course_id: courseId},
			dataType: 'json',
			success: function(response) {
				// Empty the table
				$('#coursesTbody').empty();

				// Add the courses and attendance records to the table
				$.each(response, function(index, record) {
					var attendanceStatus = record.date ? 'Present' : 'Absent';
					var attendanceDate = record.date || '-';
					var row = `<tr>
						<td>${record.course_id}</td>
						<td>${record.course_name}</td>
						<td>${attendanceStatus}</td>
						<td>${attendanceDate}</td>
					</tr>`;
					$('#coursesTbody').append(row);
				});
			},
			error: function() {
				alert('Error retrieving attendance records. Please try again.');
			}
		});
	});
});

