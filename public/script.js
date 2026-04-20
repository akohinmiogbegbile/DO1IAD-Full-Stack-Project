// This function toggles the visibility of the navigation menu on smaller screens.
function toggleMenu() {
    const menu = document.querySelector(".menu-links");
    if (!menu) return;
    menu.classList.toggle("open");
}

// This ensures that all required fields are complete before submission
function validateForm(data) {
    const requiredKeys = [
        "firstName",
        "projectDescription",
        "email",
        "confirmEmail",
        "phoneNumber",
        "preferredContact",
        "projectDate",
        "duration",
    ];

    for (let i = 0; i < requiredKeys.length; i++) {
        const key = requiredKeys[i];
        if (!data[key] || String(data[key]).trim() === "") {
            alert("Please complete all form fields before submitting.");
            return false;
        }
    }
    return true;
}

// This will ensure the email and confirm email fields match.
function checkEmails(email, confirmEmail) {
    if (email.trim() !== confirmEmail.trim()) {
        alert("Email and Confirm Email must match.");
        return false;
    }
    return true;
}

// This will ensure the project date is at least one day in the future.
function checkDate(projectDateValue) {
    const chosen = new Date(projectDateValue);
    const now = new Date();

    chosen.setHours(0, 0, 0, 0);
    now.setHours(0, 0, 0, 0);

    const diffMs = chosen.getTime() - now.getTime();
    const diffDays = diffMs / (1000 * 60 * 60 * 24);

    if (diffDays < 1) {
        alert("Project Date must be at least 1 day in the future.");
        return false;
    }
    return true;
}

// This is the main function that handles form submission, validation, and summary display.
function handleSubmit(event) {
    event.preventDefault();

    const firstName = document.getElementById("firstName").value;
    const projectDescription = document.getElementById("projectDescription").value;
    const email = document.getElementById("email").value;
    const confirmEmail = document.getElementById("confirmEmail").value;
    const phoneNumber = document.getElementById("phoneNumber").value;
    const projectDate = document.getElementById("projectDate").value;
    const duration = document.getElementById("duration").value;

    const preferredContactEl = document.querySelector(
        'input[name="preferredContact"]:checked'
    );
    const preferredContact = preferredContactEl ? preferredContactEl.value : "";

    const ASTON_EMAIL = "250435076@aston.ac.uk";

    const data = {
        firstName,
        projectDescription,
        email,
        confirmEmail,
        phoneNumber,
        preferredContact,
        projectDate,
        duration,
    };

    if (!validateForm(data)) return false;
    if (!checkEmails(email, confirmEmail)) return false;
    if (!checkDate(projectDate)) return false;

    const summary =
        "Enquiry Summary\n" +
        "-----------------------------\n" +
        "To: " + ASTON_EMAIL + "\n" +
        "From: " + email + "\n\n" +
        "First Name: " + firstName + "\n" +
        "Phone Number: " + phoneNumber + "\n" +
        "Preferred Contact Method: " + preferredContact + "\n" +
        "Project Date: " + projectDate + "\n" +
        "Project Duration: " + duration + "\n\n" +
        "Project Description:\n" + projectDescription;

    alert(summary);

    document.getElementById("contactForm").reset();
    return false;
}