<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quiz_team";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS sports_answers (
id INT AUTO_INCREMENT PRIMARY KEY,
user_name VARCHAR(100) NOT NULL UNIQUE,
team INT,
q1 VARCHAR(50),
q2 VARCHAR(50),
q3 VARCHAR(50),
q4 VARCHAR(50),
q5 VARCHAR(50),
q6 VARCHAR(50),
q7 VARCHAR(50),
q8 VARCHAR(50),
q9 VARCHAR(50),
q10 VARCHAR(50),
score INT
)";
$conn->query($sql);

function assignTeam($conn) {
    for ($team = 1; $team <= 4; $team++) {
        $result = $conn->query("SELECT COUNT(*) as count FROM sports_answers WHERE team = $team");
        $row = $result->fetch_assoc();
        if ($row['count'] < 4) {
            return $team;
        }
    }
    return null;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = $conn->real_escape_string($_POST['user_name']);

    $checkQuery = $conn->query("SELECT COUNT(*) as count FROM sports_answers WHERE user_name = '$userName'");
    $checkRow = $checkQuery->fetch_assoc();

    if ($checkRow['count'] > 0) {
        echo "<script>alert('Error: Username already exists. Please choose a different name.');</script>";
    } else {
        // اجتياز الأسئلة
        $q1 = $conn->real_escape_string($_POST['q1']);
        $q2 = $conn->real_escape_string($_POST['q2']);
        $q3 = $conn->real_escape_string($_POST['q3']);
        $q4 = $conn->real_escape_string($_POST['q4']);
        $q5 = $conn->real_escape_string($_POST['q5']);
        $q6 = $conn->real_escape_string($_POST['q6']);
        $q7 = $conn->real_escape_string($_POST['q7']);
        $q8 = $conn->real_escape_string($_POST['q8']);
        $q9 = $conn->real_escape_string($_POST['q9']);
        $q10 = $conn->real_escape_string($_POST['q10']);

        $score = 0;
        if ($q1 == "correct_answer1") $score += 1;
        if ($q2 == "correct_answer2") $score += 1;
        if ($q3 == "correct_answer3") $score += 1;
        if ($q4 == "correct_answer4") $score += 1;
        if ($q5 == "correct_answer5") $score += 1;
        if ($q6 == "correct_answer6") $score += 1;
        if ($q7 == "correct_answer7") $score += 1;
        if ($q8 == "correct_answer8") $score += 1;
        if ($q9 == "correct_answer9") $score += 1;
        if ($q10 == "correct_answer10") $score += 1;

        $team = assignTeam($conn);
        if ($team === null) {
            die("Error: All teams are full.");
        }

        $teamNames = ["1" => "Team 1", "2" => "Team 2", "3" => "Team 3", "4" => "Team 4"];
        $teamName = $teamNames[$team];

        $sql = "INSERT INTO sports_answers (user_name, team, q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, score) 
                VALUES ('$userName', '$team', '$q1', '$q2', '$q3', '$q4', '$q5', '$q6', '$q7', '$q8', '$q9', '$q10', '$score')";
        if (!$conn->query($sql)) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $result = $conn->query("SELECT MAX(score) as max_score FROM sports_answers WHERE team = $team");
        $row = $result->fetch_assoc();
        $maxScoreInTeam = $row['max_score'];

        $teamsScores = [];
        for ($i = 1; $i <= 4; $i++) {
            $result = $conn->query("SELECT AVG(score) as avg_score FROM sports_answers WHERE team = $i");
            $row = $result->fetch_assoc();
            $teamsScores[$i] = $row['avg_score'] ?? 0; 
        }
        arsort($teamsScores);
        $teamRanking = array_search($team, array_keys($teamsScores)) + 1;

        echo "<script>
            alert('Your Score: $score \\nTeam: $teamName \\nHighest Score in Your Team: $maxScoreInTeam \\nTeam Ranking: $teamRanking') ;
        </script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sports Quiz</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('https://img.freepik.com/free-photo/sports-field-stadium-night-lights_1203-2129.jpg'); 
            background-size: cover; 
            background-position: center; 
            color: #e5e5e5;
            margin: 399px;; 
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; 
        }

        h1 {
            text-align: center;
            color: #e43f5a;
            font-size: 2.5em;
            margin-bottom: 20px;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.5);
        }

        form {
            background-color: rgba(31, 64, 104, 0.8);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 500px;
        }

        label {
            font-weight: bold;
            color: #e5e5e5;
        }

        input[type="text"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0 20px 0;
            border-radius: 5px;
            border: none;
            outline: none;
            background-color: #162447;
            color: #e5e5e5;
        }

        h2 {
            font-size: 1.3em;
            color: #e43f5a;
            margin: 15px 0 5px;
        }

        p {
            font-size: 1em;
            color: #dcdde1;
        }

        input[type="radio"] {
            margin-right: 10px;
        }

        button {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 5px;
            background-color: #e43f5a;
            color: #fff;
            font-size: 1.2em;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-weight: bold;
        }

        button:hover {
            background-color: #e84a5f;
        }

        button:active {
            transform: scale(0.98);
        }

        @media (max-width: 600px) {
            form {
                padding: 20px;
                width: 90%;
            }
        }

    </style>
</head>
<body>
<form method="post">
    
    <h1>Sports Quiz</h1>
    <label for="user_name">Your Name:</label>
    <input type="text" id="user_name" name="user_name" required>

    <h2>Question 1</h2>
    <p>Which country won the FIFA World Cup in 2018?</p>
    <input type="radio" id="q1a" name="q1" value="answer1">
    <label for="q1a">Brazil</label><br>
    <input type="radio" id="q1b" name="q1" value="correct_answer1">
    <label for="q1b">France</label><br>

    <h2>Question 2</h2>
    <p>Who holds the record for the most home runs in a single MLB season?</p>
    <input type="radio" id="q2a" name="q2" value="answer2">
    <label for="q2a">Babe Ruth</label><br>
    <input type="radio" id="q2b" name="q2" value="correct_answer2">
    <label for="q2b">Barry Bonds</label><br>

    <h2>Question 3</h2>
    <p>Which sport is known as the "king of sports"?</p>
    <input type="radio" id="q3a" name="q3" value="correct_answer3">
    <label for="q3a">Football (Soccer)</label><br>
    <input type="radio" id="q3b" name="q3" value="answer3">
    <label for="q3b">Basketball</label><br>

    <h2>Question 4</h2>
    <p>What is the distance of a marathon in miles?</p>
    <input type="radio" id="q4a" name="q4" value="correct_answer4">
    <label for="q4a">26.2 miles</label><br>
    <input type="radio" id="q4b" name="q4" value="answer4">
    <label for="q4b">24 miles</label><br>

    <h2>Question 5</h2>
    <p>In which sport do players use a racket?</p>
    <input type="radio" id="q5a" name="q5" value="answer5">
    <label for="q5a">Football</label><br>
    <input type="radio" id="q5b" name="q5" value="correct_answer5">
    <label for="q5b">Tennis</label><br>

    <h2>Question 6</h2>
    <p>Which country hosted the Summer Olympics in 2008?</p>
    <input type="radio" id="q6a" name="q6" value="correct_answer6">
    <label for="q6a">China</label><br>
    <input type="radio" id="q6b" name="q6" value="answer6">
    <label for="q6b">USA</label><br>

    <h2>Question 7</h2>
    <p>What is the main goal of the game of basketball?</p>
    <input type="radio" id="q7a" name="q7" value="correct_answer7">
    <label for="q7a">Score points by shooting a ball through a hoop</label><br>
    <input type="radio" id="q7b" name="q7" value="answer7">
    <label for="q7b">Hit a ball with a bat</label><br>

    <h2>Question 8</h2>
    <p>In which sport do you perform a slam dunk?</p>
    <input type="radio" id="q8a" name="q8" value="correct_answer8">
    <label for="q8a">Basketball</label><br>
    <input type="radio" id="q8b" name="q8" value="answer8">
    <label for="q8b">Volleyball</label><br>

    <h2>Question 9</h2>
    <p>What is the maximum number of players allowed on a soccer team?</p>
    <input type="radio" id="q9a" name="q9" value="correct_answer9">
    <label for="q9a">11</label><br>
    <input type="radio" id="q9b" name="q9" value="answer9">
    <label for="q9b">9</label><br>

    <h2>Question 10</h2>
    <p>Who is known as "The Greatest" in boxing?</p>
    <input type="radio" id="q10a" name="q10" value="answer10">
    <label for="q10a">Mike Tyson</label><br>
    <input type="radio" id="q10b" name="q10" value="correct_answer10">
    <label for="q10b">Muhammad Ali</label><br>

    <button type="submit">Submit</button>
</form>
</body>
</html>
