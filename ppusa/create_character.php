<!DOCTYPE html>
<html>
<head>
    <title>Create Character</title>
    <style>
        label {
            display: block;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Create Your Character</h1>
    
    <form action="process_character.php" method="post" enctype="multipart/form-data">
        <label for="gender">Gender:</label>
        <select id="gender" name="gender">
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>

        <label for="race">Race:</label>
        <select id="race" name="race">
            <option value="white">White</option>
            <option value="black">Black</option>
        </select>

        <label for="party">Political Party:</label>
        <select id="party" name="party">
            <option value="bull_moose">Bull Moose Party</option>
            <option value="american_values">American Values Alliance</option>
            <option value="states_rights">States Rights Party</option>
        </select>

        <label for="age">Age:</label>
        <input type="number" id="age" name="age" min="1" max="100">

        <label for="state">State:</label>
        <select id="state" name="state">
            <!-- Add options for all 50 states -->
            <option value="Alabama">Alabama</option>
            <!-- Add options for other states... -->
        </select>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name">

        <label for="profile_picture">Profile Picture:</label>
        <input type="file" id="profile_picture" name="profile_picture">

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" cols="50"></textarea>

        <label for="religion">Religion:</label>
        <select id="religion" name="religion">
            <option value="catholic">Catholic</option>
            <option value="protestant">Protestant</option>
            <!-- Add options for other religions... -->
        </select>

        <br>
        <input type="submit" value="Create Character">
    </form>
</body>
</html>
