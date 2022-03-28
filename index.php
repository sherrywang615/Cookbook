<html>

<head>
    <title>CPSC 304 Group 28</title>
    <link href="/style.css" rel="stylesheet" />
</head>

<body>
    <h1>CPSC 304 Project Group 28 </h1>
    <h2>New User? Create Account Here! (Insert)</h2>
    <form method="POST" action="index.php">
        <!--refresh page when submitted-->
        <input type="hidden" id="createAccountRequest" name="createAccountRequest">
        Username: <input type="text" name="username"> <br /><br />
        Password: <input type="text" name="userPassword"> <br /><br />

        <input type="submit" value="Create account" name="createAccountSubmit"></p>
    </form>


    <h2>Update Account Info (Update)</h2>
    <p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>

    <form method="POST" action="index.php">
        <!--refresh page when submitted-->
        <input type="hidden" id="updateAccountRequest" name="updateAccountRequest">
        Old Username: <input type="text" name="oldUsername"> &nbsp &nbsp
        New Username: <input type="text" name="newUsername"> <br /><br />
        Old Password: <input type="text" name="oldPassword"> &nbsp &nbsp
        New Password: <input type="text" name="newPassword"> <br /><br />

        <input type="submit" value="Update" name="updateSubmit"></p>
    </form>

    <hr />

    <h2>Delete Ingredient (Delete)</h2>
    <form method="POST" action="index.php">
        <!--refresh page when submitted-->
        <input type="hidden" id="deleteIngredientRequest" name="deleteIngredientRequest">
        Ingredient ID: <input type="text" name="deleteIngredientID"> <br /><br />

        <input type="submit" value="Delete Ingredient" name="deleteIngredientSubmit"></p>
    </form>


    <h2>Filter Recipes By Preparation Time (Select) </h2>
    <form method="GET" action="index.php">
        <!--refresh page when submitted-->
        <input type="hidden" id="filterRecipePreparationTimeRequest" name="filterRecipePreparationTimeRequest">
        Preparation Time Under: <input type="text" name="preparationTimeUnder">&nbsp mins<br /><br />

        <input type="submit" value="Filter Recipe" name="filterRecipeSubmit"></p>
    </form>


    <h2>View Recipe ID, Recipe Name, Preparation Time, or Difficulty for All Recipes (Projection)</h2>
    <form method="GET" action="index.php">
        <!--refresh page when submitted-->
        <input type="hidden" id="viewAttributesRequest" name="viewAttributesRequest">
        <label for=" recipeAttribute"> Select Recipe Attribute:</label>
        <select name="recipeAttribute" id="recipeAttribute">
            <option value="selectID">Recipe ID</option>
            <option value="selectName">Recipe Name</option>
            <option value="selectPrepTime">Preparation Time</option>
            <option value="selectDifficulty">Difficulty</option>
        </select><br /><br />

        <input type="submit" value="View" name="viewAttributesSubmit"></p>
    </form>


    <h2>List All Ingredients Needed For Your Recipe (join recipeID_Name, requires, ingredient)</h2>
    <form method="GET" action="index.php">
        <!--refresh page when submitted-->
        <input type="hidden" id="listIngredientsRequest" name="listIngredientsRequest">
        Recipe Name: <input type="text" name="listIngredientsRecipeName"><br /><br />

        <input type="submit" value="List Ingredients" name="listIngredientsSubmit"></p>
    </form>


    <h2>Find the Recipes with the Lowest Difficulty (Aggregation)</h2>
    <form method="GET" action="index.php">
        <!--refresh page when submitted-->
        <input type="hidden" id="findMinDifficultyRequest" name="findMinDifficultyRequest">

        <input type="submit" value="Search" name="findMinDifficultySubmit"></p>
    </form>


    <h2>Count the Number of Ingredients Used For Each Recipe (Nested aggregation)</h2>
    <form method="GET" action="index.php">
        <!--refresh page when submitted-->
        <input type="hidden" id="countIngredientsRequest" name="countIngredientsRequest">

        <input type="submit" value="View" name="countIngredientsSubmit"></p>
    </form>


    <h2>Find All Ingredients that Appear in All Recipes (Division)</h2>
    <form method="GET" action="index.php">
        <!--refresh page when submitted-->
        <input type="hidden" id="findAllIngredientsRequest" name="findAllIngredientsRequest">

        <input type="submit" value="View" name="findAllIngredientsSubmit"></p>
    </form>


    <?php
    //this tells the system that it's no longer just parsing html; it's now parsing PHP

    $success = True; //keep track of errors so it redirects the page only if there are no errors
    $db_conn = NULL; // edit the login credentials in connectToDB()
    $show_debug_alert_messages = False; // set to True if you want alerts to show you which methods are being triggered (see how it is used in debugAlertMessage())

    function debugAlertMessage($message)
    {
        global $show_debug_alert_messages;

        if ($show_debug_alert_messages) {
            echo "<script type='text/javascript'>alert('" . $message . "');</script>";
        }
    }

    function executePlainSQL($cmdstr)
    { //takes a plain (no bound variables) SQL command and executes it
        //echo "<br>running ".$cmdstr."<br>";
        global $db_conn, $success;

        $statement = OCIParse($db_conn, $cmdstr);
        //There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work

        if (!$statement) {
            echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
            $e = OCI_Error($db_conn); // For OCIParse errors pass the connection handle
            echo htmlentities($e['message']);
            $success = False;
        }

        $r = OCIExecute($statement, OCI_DEFAULT);
        if (!$r) {
            echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
            $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
            echo htmlentities($e['message']);
            $success = False;
        }

        return $statement;
    }

    function executeBoundSQL($cmdstr, $list)
    {
        /* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
		In this case you don't need to create the statement several times. Bound variables cause a statement to only be
		parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection.
		See the sample code below for how this function is used */

        global $db_conn, $success;
        $statement = OCIParse($db_conn, $cmdstr);

        if (!$statement) {
            echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
            $e = OCI_Error($db_conn);
            echo htmlentities($e['message']);
            $success = False;
        }

        foreach ($list as $tuple) {
            foreach ($tuple as $bind => $val) {
                //echo $val;
                //echo "<br>".$bind."<br>";
                OCIBindByName($statement, $bind, $val);
                unset($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
            }

            $r = OCIExecute($statement, OCI_DEFAULT);
            if (!$r) {
                echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($statement); // For OCIExecute errors, pass the statementhandle
                echo htmlentities($e['message']);
                echo "<br>";
                $success = False;
            }
        }
    }

    function connectToDB()
    {
        global $db_conn;

        // Your username is ora_(CWL_ID) and the password is a(student number). For example,
        // ora_platypus is the username and a12345678 is the password.
        $db_conn = OCILogon("ora_xwang90", "a47381579", "dbhost.students.cs.ubc.ca:1522/stu");

        if ($db_conn) {
            debugAlertMessage("Database is Connected");
            return true;
        } else {
            debugAlertMessage("Cannot connect to Database");
            $e = OCI_Error(); // For OCILogon errors pass no handle
            echo htmlentities($e['message']);
            return false;
        }
    }

    function disconnectFromDB()
    {
        global $db_conn;

        debugAlertMessage("Disconnect from Database");
        OCILogoff($db_conn);
    }

    function handleUpdateAccountRequest()
    {
        global $db_conn;

        $old_username = $_POST['oldUsername'];
        $new_username = $_POST['newUsername'];
        $old_password = $_POST['oldPassword'];
        $new_password = $_POST['newPassword'];

        $result_1 = executePlainSQL("SELECT Count(*) FROM Users WHERE username = '$old_username' AND password = '$old_password'");
        if (oci_fetch_row($result_1) != false) {
            executePlainSQL("UPDATE Users SET username='$new_username', userPassword='$new_password' WHERE username='$old_username' AND userPassword='$old_password");
        } else {
            echo "Old username or old password does not exist";
        }

        printUsers();

        OCICommit($db_conn);
    }

    function handleCreateAccountRequest()
    {
        global $db_conn;

        //Check if the username already exists
        $nameEntered = $_POST['username'];
        $result_1 = executePlainSQL("SELECT Count(*) FROM Users WHERE username = '$nameEntered'");
        if (oci_fetch_row($result_1) != false) {
            echo "Username already exists";
        } else {
            $tuple = array(
                ":bind1" => $_POST['username'],
                ":bind2" => $_POST['userPassword']
            );

            $userID = uniqid("user_");
            
            $alltuples = array(
                $tuple
            );

            executeBoundSQL("Insert into Users values ('$userID', :bind1, :bind2)", $alltuples);
        }

        printUsers();
        OCICommit($db_conn);
    }

    function printUsers()
    {
        global $db_conn;

        $result = executePlainSQL("SELECT * FROM Users");

        echo "Users Table";
        echo "<table>";
        echo "<tr><th>User ID</th><th>Username</th><th>Password</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";
    }

    function handleViewAttributeRequest() {
        global $db_conn;

        $attribute = $_GET['recipeAttribute'];
        $result = executePlainSQL("SELECT $attribute FROM Recipe_1, Recipe_2, Recipe_3 WHERE Recipe_1.recipeName = Recipe_2.recipeName 
        AND Recipe_2.preparationTime = Recipe_3.preparationTime");

        echo "Attribute Table";
        echo "<table>";
        echo "<tr><th>Recipe ID</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";
    }

    function printRecipes()
    {
        global $db_conn;

        $result = executePlainSQL("SELECT * FROM Recipe_1, Recipe_2, Recipe_3 WHERE Recipe_1.recipeName = Recipe_2.recipeName 
        AND Recipe_2.preparationTime = Recipe_3.preparationTime");

        echo "Recipe Table";
        echo "<table>";
        echo "<tr><th>Recipe ID</th><th>Recipe Name</th><th>Preparation Time</th><th>Difficulty</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";
    }

    function printIngredients()
    {
        global $db_conn;

        $result = executePlainSQL("SELECT * FROM Ingredient");

        echo "Ingredient Table";
        echo "<table>";
        echo "<tr><th>Ingredient ID</th><th>Ingredient Name</th><th>Amount</th><th>Unit</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";
    }

    function printRequires_1() {
        global $db_conn;

        $result = executePlainSQL("SELECT * FROM Requires_1");

        echo "Requires_1 Table";
        echo "<table>";
        echo "<tr><th>Recipe ID</th><th>Ingredient ID</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";
    }

    function handleDeleteIngredientRequest()
    {
        global $db_conn;

        $ingredientID = $_POST['deleteIngredientID'];
        $result_1 = executePlainSQL("SELECT Count(*) FROM Ingredient WHERE ingredientID = '$ingredientID'");

        if (($row = oci_fetch_row($result_1)) != false) {
            executePlainSQL("DELETE FROM Ingredient WHERE ingredientID = '$ingredientID");
        } else {
            echo "Ingredient ID does not exist";
        }

        printIngredients();
        printRequires_1();
        OCICommit($db_conn);
    }

    function handleFilterRecipeRequest()
    {
        global $db_conn;

        $prepTime = $_GET['preparationTimeUnder'];
        $result = executePlainSQL("SELECT * FROM Recipe_1, Recipe_2, Recipe_3
        WHERE Recipe_1.recipeName = Recipe_2.recipeName AND Recipe_2.preparationTime = Recipe_3.preparationTime AND Recipe_2.preparationTime < '$prepTime'");

        echo "Selection Query";
        echo "<table>";
        echo "<tr><th>Recipe ID</th><th>Recipe Name</th><th>Preparation Time</th><th>Difficulty</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";
    }

    function handleListIngredientsRequest()
    {
        global $db_conn;

        $result = executePlainSQL("SELECT I.ingredientID, ingredientName, amount, unit FROM Recipe_1, Requires_1, Ingredient I
        WHERE Recipe_1.recipeID = Requires_1.recipeID AND Requires_1.ingredientID = Ingredient.ingredientID AND Recipe_1.recipeName = '$recipeName'");

        echo "Join Query";
        echo "<table>";
        echo "<tr><th>Ingredient ID</th><th>Ingredient Name</th><th>Amount</th><th>Unit</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";
    }

    function handleFindMinDifficultyRequest()
    {
        global $db_conn;

        $result = executePlainSQL("SELECT R1.recipeID, R1.recipeName, difficulty FROM Recipe_1 R1, Recipe_2 R2, Recipe_3 R3
        WHERE R1.recipeName = R2.recipeName AND R2.preparationTime = R3.preparationTime AND R3.difficulty = (SELECT MIN(R32.difficulty) FROM Recipe_3 R32)");

        echo "Aggregation Query";
        echo "<table>";
        echo "<tr><th>Recipe ID</th><th>Recipe Name</th><th>Difficulty</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";
    }

    function handleCountIngredientsRequest()
    {
        global $db_conn;

        $result = executePlainSQL("SELECT recipeID, recipeName, COUNT(Ingredient.ingredientID) FROM Requires_1, Ingredient 
        WHERE Requires_1.ingredientID = Ingredient.ingredientID GROUP BY recipeID");

        echo "Nested Aggregation Query";
        echo "<table>";
        echo "<tr><th>Recipe ID</th><th>Recipe Name</th><th>Number of Ingredients</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";
    }

    function handleFindIngredientsInAllRecipeRequest()
    {
        global $db_conn;

        $result = executePlainSQL("SELECT ingredientID, ingredientName FROM Ingredient WHERE NOT EXISTS 
        ((SELECT Recipe_1.recipeID FROM Recipe_1) EXCEPT (SELECT Requires_1.recipeID FROM Requires_1 
        WHERE Requires_1.ingredientID = Ingredient.ingredientID))");

        echo "Division Query";
        echo "<table>";
        echo "<tr><th>Ingredient ID</th><th>Ingredient Name</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";
    }


    // function handleCountRequest()
    // {
    //     global $db_conn;

    //     $result = executePlainSQL("SELECT Count(*) FROM demoTable");

    //     if (($row = oci_fetch_row($result)) != false) {
    //         echo "<br> The number of tuples in demoTable: " . $row[0] . "<br>";
    //     }
    // }

    // HANDLE ALL POST ROUTES
    // A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
    function handlePOSTRequest()
    {
        if (connectToDB()) {
            if (array_key_exists('createAccountRequest', $_POST)) {
                handleCreateAccountRequest();
            } else if (array_key_exists('updateAccountRequest', $_POST)) {
                handleUpdateAccountRequest();
            } else if (array_key_exists('deleteIngredientRequest', $_POST)) {
                handleDeleteIngredientRequest();
            }
            disconnectFromDB();
        }
    }

    // HANDLE ALL GET ROUTES
    // A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
    function handleGETRequest()
    {
        if (connectToDB()) {
            if (array_key_exists('filterRecipePreparationTimeRequest', $_GET)) {
                handleFilterRecipeRequest();
            } else if (array_key_exists('listIngredientsRequest', $_GET)) {
                handleListIngredientsRequest();
            } else if (array_key_exists('findMinDifficultyRequest', $_GET)) {
                handleFindMinDifficultyRequest();
            } else if (array_key_exists('countIngredientsRequest', $_GET)) {
                handleCountIngredientsRequest();
            } else if (array_key_exists('findAllIngredientsRequest', $_GET)) {
                handleFindIngredientsInAllRecipeRequest();
            } else if (array_key_exists('viewAttributesRequest', $_GET)) {
                handleViewAttributeRequest();
            }
            disconnectFromDB();
        }
    }

    if (isset($_POST['createAccountSubmit']) || isset($_POST['updateSubmit']) || isset($_POST['deleteIngredientSubmit'])) {
        handlePOSTRequest();
    } else if (
        isset($_GET['filterRecipeSubmit']) || isset($_GET['listIngredientsSubmit']) || isset($_GET['findMinDifficultySubmit'])
        || isset($_GET['countIngredientsSubmit']) || isset($_GET['findAllIngredientsSubmit']) || isset($_GET['viewAttributesSubmit'])
    ) {
        handleGETRequest();
    }
    ?>
</body>
</html>