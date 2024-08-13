<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
    <Style>
        /* Make sure the body and html take full height */
html, body {
    height: 100%;
    margin: 0;
    display: flex;
    flex-direction: column;
}

/* The content container should take all available space */
.container-fluid {
    flex: 1;
}

/* Footer styling */
.footer {
    background-color: #045db5;
    color: white;
    padding: 1rem 0;
    text-align: center;
    position: sticky;
    bottom: 0;
    width: 100%;
}

.footer a {
    color: #ffffff;
    text-decoration: none;
    margin: 0 1rem;
    transition: color 0.3s ease-in-out;
}

.footer a:hover {
    color: #0080ff;
}


    </Style>


</head>
<body>
   
<footer class="footer">
    <div class="container text-center">
        <span>&copy; 2024 IMS. All rights reserved.</span>
        <span><a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></span>
    </div>
</footer>
 

</body>
</html>