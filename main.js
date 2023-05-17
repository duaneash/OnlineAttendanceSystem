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
            xhr.open('POST', 'process_course.php', true);
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

