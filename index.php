<html>

<head>
    <title>CPSC 304 Group 28</title>
</head>

<body>
    <h1>CPSC 304 Project Group 28 </h1>
    <h2>Reset</h2>
    <p>If you wish to reset the table press on the reset button. If this is the first time you're running this page, you MUST use reset</p>

    <form method="POST" action="oracle-test.php">
        <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
        <input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
        <p><input type="submit" value="Reset" name="reset"></p>
    </form>

    <hr />

    <h2>New User? Create Account Here!</h2>
    <form method="POST" action="index.php">
        <!--refresh page when submitted-->
        <input type="hidden" id="createAccountRequest" name="createAccountRequest">
        Username: <input type="text" name="username"> <br /><br />
        Password: <input type="text" name="userPassword"> <br /><br />

        <input type="submit" value="Create account" name="createAccountSubmit"></p>
    </form>

    <hr />

    <h2>Update Account Info</h2>
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

    <h2>Add New Recipes</h2>
    <form method="POST" action="index.php">
        <!--refresh page when submitted-->
        <input type="hidden" id="addRecipeRequest" name="addRecipeRequest">
        RecipeName: <input type="text" name="recipeName"> <br /><br />
        PreparationTime &#40In minutes&#41: <input type="text" name="preparationTime">&nbsp mins <br /><br />
        Difficulty &#40Rate on a scale of 1-10&#41: <input type="text" name="difficulty"> <br /><br />

        <input type="submit" value="Add Recipe" name="addRecipeSubmit"></p>
    </form>

    <hr />

    <h2>Delete Recipes</h2>
    <form method="GET" action="index.php">
        <!--refresh page when submitted-->
        <input type="hidden" id="deleteRecipeRequest" name="deleteRecipeRequest">
        RecipeID: <input type="text" name="recipeName"> <br /><br />

        <input type="submit" value="Delete Recipe" name="deleteRecipeSubmit"></p>
    </form>

    <hr />

    <h2>Looking For A Quick Recipe? Filter Recipes By Preparation Time!(select) </h2>
    <form method="GET" action="index.php">
        <!--refresh page when submitted-->
        <input type="hidden" id="filterRecipePreparationTimeRequest" name="filterRecipePreparationTimeRequest">
        Preparation Time Under: <input type="text" name="preparationTimeUnder">&nbsp mins<br /><br />

        <input type="submit" value="Search Recipe" name="filterRecipeSubmit"></p>
    </form>

    <hr />

    <h2>Projection</h2>
    <form method="GET" action="index.php">
        <!--refresh page when submitted-->

        <input type="submit" value="View" name="viewRecipeSubmit"></p>
    </form>

    <hr />

    <h2>List All Ingredients Needed For Your Recipe (join recipeID_Name, requires, ingredient)</h2>
    <form method="GET" action="index.php">
        <!--refresh page when submitted-->
        <input type="hidden" id="listIngredientsRequest" name="listIngredientsRequest">
        Recipe Title: <input type="text" name="recipeTitle"><br /><br />

        <input type="submit" value="List Ingredients" name="listIngredientsSubmit"></p>
    </form>

    <hr />

    <h2>Find the Recipes with the Highest Difficulty (Aggregation)</h2>
    <form method="GET" action="index.php">
        <!--refresh page when submitted-->
        <input type="hidden" id="findMaxDifficultyRequest" name="findMaxDifficultyRequest">

        <input type="submit" value="Search" name="findMaxDifficultySubmit"></p>
    </form>

    <hr />

    <h2>Find the Recipes with the Lowest Difficulty (Aggregation)</h2>
    <form method="GET" action="index.php">
        <!--refresh page when submitted-->
        <input type="hidden" id="findMinDifficultyRequest" name="findMinDifficultyRequest">

        <input type="submit" value="Search" name="findMinDifficultySubmit"></p>
    </form>

    <hr />

    <h2>Count the Number of Ingredients Used For Each Recipe (Nested aggregation)</h2>
    <form method="GET" action="index.php">
        <!--refresh page when submitted-->
        <input type="hidden" id="findMinDifficultyRequest" name="findMinDifficultyRequest">

        <input type="submit" value="Search" name="findMinDifficultySubmit"></p>
    </form>

    <hr />

    <h2>Count the Tuples in DemoTable</h2>
    <form method="GET" action="oracle-test.php">
        <!--refresh page when submitted-->
        <input type="hidden" id="countTupleRequest" name="countTupleRequest">
        <input type="submit" name="countTuples"></p>
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

    function printPreparationTimeResult($result)
    { //prints results from a select statement
        echo "<br>Retrieved data from Recipe table:<br>";
        echo "<table>";
        echo "<tr><th>Recipe ID</th><th>Title</th><th>Preparation Time</th><th>Difficulty</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";
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

    function handleUpdateRequest()
    {
        global $db_conn;

        $old_name = $_POST['oldUsername'];
        $new_name = $_POST['newUsername'];

        // you need the wrap the old name and new name values with single quotations
        executePlainSQL("UPDATE User SET name='" . $new_name . "' WHERE name='" . $old_name . "'");
        OCICommit($db_conn);
    }

    function handleResetRequest()
    {
        global $db_conn;
        // Drop old table
        executePlainSQL("DROP TABLE demoTable");

        // Create new table
        echo "<br> creating new table <br>";
        executePlainSQL("CREATE TABLE demoTable (id int PRIMARY KEY, name char(30))");
        OCICommit($db_conn);
    }

    function handleInsertRequest()
    {
        global $db_conn;

        //Getting the values from user and insert data into the table
        $tuple = array(
            ":bind1" => $_POST['username'],
            ":bind2" => $_POST['userPassword']
        );

        $alltuples = array(
            $tuple
        );

        executeBoundSQL("insert into user values (:bind1, :bind2)", $alltuples);
        OCICommit($db_conn);
    }

    function handleCountRequest()
    {
        global $db_conn;

        $result = executePlainSQL("SELECT Count(*) FROM demoTable");

        if (($row = oci_fetch_row($result)) != false) {
            echo "<br> The number of tuples in demoTable: " . $row[0] . "<br>";
        }
    }

    // HANDLE ALL POST ROUTES
    // A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
    function handlePOSTRequest()
    {
        if (connectToDB()) {
            if (array_key_exists('resetTablesRequest', $_POST)) {
                handleResetRequest();
            } else if (array_key_exists('updateQueryRequest', $_POST)) {
                handleUpdateRequest();
            } else if (array_key_exists('insertQueryRequest', $_POST)) {
                handleInsertRequest();
            }

            disconnectFromDB();
        }
    }

    // HANDLE ALL GET ROUTES
    // A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
    function handleGETRequest()
    {
        if (connectToDB()) {
            if (array_key_exists('countTuples', $_GET)) {
                handleCountRequest();
            }

            disconnectFromDB();
        }
    }

    if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit'])) {
        handlePOSTRequest();
    } else if (isset($_GET['countTupleRequest'])) {
        handleGETRequest();
    }
    ?>
</body>

</html>