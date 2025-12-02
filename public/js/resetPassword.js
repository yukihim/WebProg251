function handleResetProcess(first_name, last_name, newPassword, email) {
    let params = {
        subject: "Password Reset",
        userName: first_name + " " + last_name,
        message: "Your new password is: " + newPassword,
        receiverEmail: email,
        senderName: "The Exclusive Garage"
    }

    emailjs.send("service_1hcvss7", "template_ivgz5qi", params)
    .then((response) => {
        console.log("EmailJS Response:", response);
        alert("Email sent successfully!");
        window.location.href = "/quanswebsite/public/login.php";
    })
    .catch((error) => {
        console.error("EmailJS Error:", error);
        alert("Failed to send email. Please try again later.");
    });
}