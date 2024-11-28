<html>
<head>
    <title>My Phonebook</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>My Phonebook</h2>
            <div>
                <input type="text" id="searchInput" class="search-box" placeholder="Search contacts...">
                <a href="index.html" class="btn">Add New Contact</a>
                <input type="button" id="getusers" class="btn" value="Refresh">
            </div>
        </div>

        <div id="loading">Loading contacts...</div>
        <div id="records" class="contact-grid"></div>
    </div>

    <script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="contacts.js"></script>
</body>
</html>
