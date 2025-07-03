# 👤 User Management System with OTP Login and Email Verification

This project is a **User Details Management System** built with **PHP**, **MySQL**, **AJAX**, and **PHPMailer**, styled using **HTML**, **CSS**, and **Bootstrap**.

It includes core CRUD features (Create, Read, Update, Delete) with session-based login, OTP verification using email, and user search functionality.

---

## 🔧 Features

✅ **Add New User**  
✅ **Update Existing User**  
✅ **Delete User**  
✅ **View All Users**  
✅ **Search for a Specific User**  
✅ **Session Management**  
✅ **Signup with Email Confirmation using PHPMailer**  
✅ **Login with OTP Verification (One-Time Password)**  
✅ **Responsive UI using Bootstrap**

---

## 📂 Folder Structure

/user_details/

├── usersign.php # Add new user to DB + send email via PHPMailer
├── ajax.php # usersign with unique email and unique username
├── update.php # Update existing user details
├── dashboard.php # Delete user from DB # search single user
├── index.php # Landing page or redirect + Login with OTP sending
├── send_otp.php # OTP send + OTP verification logic
├── dashboard.php # Protected page (requires session)
├── logout.php # Destroy session
├── connection.php # DB connection
├── send_mail.php # PHPMailer configuration
├── style.css # Optional custom CSS
└── README.md # Project info

## ⚙️ Technologies Used

- **Frontend**: HTML5, CSS3, Bootstrap 5
- **Backend**: PHP (Core PHP)
- **Database**: MySQL
- **Email**: PHPMailer (SMTP configured)
- **AJAX**: For dynamic search functionality

---

## 💡 How It Works

### 🔐 Signup with Email Verification
1. User fills the signup form.
2. On submission, PHPMailer sends a confirmation email to the user.
3. The user clicks the link to activate the account.

### 🔑 Login with OTP
1. User logs in using email/password.
2. PHP generates a 6-digit OTP and sends it to the user’s email using PHPMailer.
3. User enters OTP.
4. On correct OTP, session is started and user is redirected to the dashboard.

### 👥 User Management (CRUD)
- Admin can add, edit, delete, or search users.
- Each user can be managed via a Bootstrap-styled interface.
- Actions use AJAX for dynamic interactivity.
