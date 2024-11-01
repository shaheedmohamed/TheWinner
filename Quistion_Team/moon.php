<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quiz_team";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS Space_answers (
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
    $result = $conn->query("SELECT COUNT(*) as count FROM answers WHERE team = $team");
    $row = $result->fetch_assoc();
    if ($row['count'] < 4) {
        return $team;
    }
}
return null;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$userName = $conn->real_escape_string($_POST['user_name']);

$checkQuery = $conn->query("SELECT COUNT(*) as count FROM answers WHERE user_name = '$userName'");
$checkRow = $checkQuery->fetch_assoc();

if ($checkRow['count'] > 0) {
    echo "<script>alert('Error: Username already exists. Please choose a different name.');</script>";
} else {
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

    $sql = "INSERT INTO answers (user_name, team, q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, score) 
            VALUES ('$userName', '$team', '$q1', '$q2', '$q3', '$q4', '$q5', '$q6', '$q7', '$q8', '$q9', '$q10', '$score')";
    if (!$conn->query($sql)) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $result = $conn->query("SELECT MAX(score) as max_score FROM answers WHERE team = $team");
    $row = $result->fetch_assoc();
    $maxScoreInTeam = $row['max_score'];

    $teamsScores = [];
    for ($i = 1; $i <= 4; $i++) {
        $result = $conn->query("SELECT AVG(score) as avg_score FROM answers WHERE team = $i");
        $row = $result->fetch_assoc();
        $teamsScores[$i] = $row['avg_score'] ?? 0; 
    }
    arsort($teamsScores);
    $teamRanking = array_search($team, array_keys($teamsScores)) + 1;

    echo "<script>
        alert('Your Score: $score \\nTeam: $teamName \\nHighest Score in Your Team: $maxScoreInTeam \\nTeam Ranking: $teamRanking');
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
<title>Quiz</title>
<style>

    body {
        font-family: Arial, sans-serif;
        background-image: url('https://img.freepik.com/free-photo/galactic-night-sky-astronomy-science-combined-generative-ai_188544-9656.jpg'); 
        background-size: cover; 
        background-position: center; 
        color: #e5e5e5;
        margin: 399px; 
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
        background-color: rgba(31, 64, 104, 0.8); /* لون الخلفية مع شفافية */
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
    <h1>Space Quiz</h1>
    <label for="user_name">Your Name:</label>
    <input type="text" id="user_name" name="user_name" required>

    <h2>Question 1</h2>
    <p>What is the closest planet to the Sun?</p>
    <input type="radio" id="q1a" name="q1" value="answer1">
    <label for="q1a">Earth</label><br>
    <input type="radio" id="q1b" name="q1" value="correct_answer1">
    <label for="q1b">Mercury</label><br>

    <h2>Question 2</h2>
    <p>What planet is known as the Red Planet?</p>
    <input type="radio" id="q2a" name="q2" value="answer2">
    <label for="q2a">Jupiter</label><br>
    <input type="radio" id="q2b" name="q2" value="correct_answer2">
    <label for="q2b">Mars</label><br>

    <h2>Question 3</h2>
    <p>Which planet has the most moons?</p>
    <input type="radio" id="q3a" name="q3" value="correct_answer3">
    <label for="q3a">Saturn</label><br>
    <input type="radio" id="q3b" name="q3" value="answer3">
    <label for="q3b">Mars</label><br>

    <h2>Question 4</h2>
    <p>What is the largest planet in our solar system?</p>
    <input type="radio" id="q4a" name="q4" value="answer4">
    <label for="q4a">Earth</label><br>
    <input type="radio" id="q4b" name="q4" value="correct_answer4">
    <label for="q4b">Jupiter</label><br>

    <h2>Question 5</h2>
    <p>What is the hottest planet in the solar system?</p>
    <input type="radio" id="q5a" name="q5" value="answer5">
    <label for="q5a">Mercury</label><br>
    <input type="radio" id="q5b" name="q5" value="correct_answer5">
    <label for="q5b">Venus</label><br>

    <h2>Question 6</h2>
    <p>Which planet is known as the "Gas Giant"?</p>
    <input type="radio" id="q6a" name="q6" value="correct_answer6">
    <label for="q6a">Jupiter</label><br>
    <input type="radio" id="q6b" name="q6" value="answer6">
    <label for="q6b">Earth</label><br>

    <h2>Question 7</h2>
    <p>Which planet is famous for its beautiful rings?</p>
    <input type="radio" id="q7a" name="q7" value="correct_answer7">
    <label for="q7a">Saturn</label><br>
    <input type="radio" id="q7b" name="q7" value="answer7">
    <label for="q7b">Uranus</label><br>

    <h2>Question 8</h2>
    <p>What planet is known as the "Blue Planet"?</p>
    <input type="radio" id="q8a" name="q8" value="correct_answer8">
    <label for="q8a">Earth</label><br>
    <input type="radio" id="q8b" name="q8" value="answer8">
    <label for="q8b">Neptune</label><br>

    <h2>Question 9</h2>
    <p>What planet is known as the "Evening Star"?</p>
    <input type="radio" id="q9a" name="q9" value="correct_answer9">
    <label for="q9a">Venus</label><br>
    <input type="radio" id="q9b" name="q9" value="answer9">
    <label for="q9b">Mars</label><br>

    <h2>Question 10</h2>
    <p>What planet is farthest from the Sun?</p>
    <input type="radio" id="q10a" name="q10" value="correct_answer10">
    <label for="q10a">Neptune</label><br>
    <input type="radio" id="q10b" name="q10" value="answer10">
    <label for="q10b">Pluto</label><br>

    <button type="submit">Submit</button>
</form>
</body>
</html>
