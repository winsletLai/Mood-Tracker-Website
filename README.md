# MindCare+

MindCare+ is a web-based mental wellness support system designed to help users track their emotional well-being and seek support when needed. The platform allows users to log their mood, review mood history through a calendar interface, and communicate with consultants through a real-time chat system.

This project was developed as part of a Web Development coursework project.

---

## Features

### Mood Logging & Tracker
Users can log their daily mood along with optional notes. This helps users reflect on their emotional patterns over time.

### Calendar History View
A calendar interface allows users to review previously recorded moods and monitor their emotional trends.

### Real-Time Chat System
Users can communicate with consultants through a messaging system to seek emotional support.

### Admin Panel
Administrators can manage users and system data through basic **CRUD operations** (Create, Read, Update, Delete).

---

## Technologies Used

- **Frontend:** HTML, CSS, JavaScript  
- **Backend:** PHP  
- **Database:** MySQL  
- **Local Server:** XAMPP  

---

## Installation Guide

### Requirements
Before running the project, ensure the following are installed:

- XAMPP (Apache & MySQL)
- Web browser

---

### Setup Instructions

1. **Clone the repository**

2. **Move the project folder**

Place the project inside the `htdocs` directory of your XAMPP installation.

Example:
```
xampp/htdocs/mindcare-plus
```

3. **Start XAMPP**

Start the following services:
- Apache
- MySQL

4. **Create the Database**

- Open **phpMyAdmin**
- Create a new database
- Import the **DDL file located in the `database` folder**

5. **Run the Project**

Open your browser and go to:

```
http://localhost/Mood-Tracker-Website

```

## Notes

- This project runs **locally using XAMPP**.
- The database must be created manually before running the system.
- The SQL **DDL file is provided in the `database` folder**.

---

## Authors

Developed by students as part of a Web Development coursework project.
