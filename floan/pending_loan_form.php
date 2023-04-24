<!DOCTYPE html>
<html>

<head>
    <title>Search by ID</title>
    <style>
        h1 {
            margin-bottom: 10px;
            font-size: 28px;
            font-weight: bold;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid black;
            width: 50%;
        }

        label {
            margin-bottom: 10px;
            font-size: 18px;
        }

        input[type="number"] {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid black;
            margin-bottom: 20px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            font-size: 18px;
            border-radius: 5px;
            border: none;
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0062cc;
        }

        .result {
            margin: 20px auto;
            padding: 20px;
            border: 1px solid black;
            width: 50%;
        }

        .result h1 {
            font-size: 24px;
            margin-bottom: 10px;
            text-align: center;
        }

        .result p {
            font-size: 18px;
            margin-bottom: 5px;
            line-height: 1.5;
        }

        .result span {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h1>Search by ID for Loan</h1>
    <form method="post" action="search_loan.php">
        <label>Enter Loan Number:</label>
        <input type="number" name="id">
        <input type="submit" name="submit" value="Search">
    </form>


</body>

</html>