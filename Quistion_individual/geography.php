<!DOCTYPE html>
<html lang="en">
<head>
     <!-- Meta tags for character set and responsive design -->
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Geography Quiz</title>
     <style>
          /* Styling for the body background, font, and layout */
          body {
               font-family: Arial, sans-serif;
               background-image: url('./wallpaperflare.com_wallpaper.jpg'); 
               background-size: cover; 
               background-position: center; 
               color: #e5e5e5;
               margin: 0; 
               padding: 0;
               display: flex;
               justify-content: center;
               align-items: center;
               height: 100vh; 
          }

          /* Styling for the main heading */
          h1 {
               text-align: center;
               color: #e43f5a;
               font-size: 2.5em;
               margin-bottom: 20px;
               text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.5);
          }

          /* Styling for the form container */
          form {
               background-color: rgba(31, 64, 104, 0.8);
               padding: 30px;
               border-radius: 10px;
               box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.5);
               width: 100%;
               max-width: 500px;
          }

          /* Styling for labels */
          label {
               font-weight: bold;
               color: #e5e5e5;
          }

          /* Styling for text input fields */
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

          /* Styling for subheadings (question titles) */
          h2 {
               font-size: 1.3em;
               color: #e43f5a;
               margin: 15px 0 5px;
          }

          /* Styling for question text */
          p {
               font-size: 1em;
               color: #dcdde1;
          }

          /* Styling for radio buttons */
          input[type="radio"] {
               margin-right: 10px;
          }

          /* Styling for the submit button */
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

          /* Hover effect for the submit button */
          button:hover {
               background-color: #e84a5f;
          }

          /* Active effect for the submit button */
          button:active {
               transform: scale(0.98);
          }

          /* Responsive styling for small screens */
          @media (max-width: 600px) {
               form {
                    padding: 20px;
                    width: 90%;
               }
          }
     </style>
</head>
<body>
     <!-- Quiz form for geography questions -->
     <form method="post">
          <h1>Geography Quiz</h1>
          
          <!-- Input for user's name -->
          <label for="user_name">Your Name:</label>
          <input type="text" id="user_name" name="user_name" required>

          <!-- Questions -->
          <h2>Question 1</h2>
          <p>What is the largest country in the world by area?</p>
          <input type="radio" id="q1a" name="q1" value="answer1">
          <label for="q1a">Canada</label><br>
          <input type="radio" id="q1b" name="q1" value="correct_answer1">
          <label for="q1b">Russia</label><br>

          <h2>Question 2</h2>
          <p>What is the longest river in the world?</p>
          <input type="radio" id="q2a" name="q2" value="answer2">
          <label for="q2a">Amazon River</label><br>
          <input type="radio" id="q2b" name="q2" value="correct_answer2">
          <label for="q2b">Nile River</label><br>

          <h2>Question 3</h2>
          <p>Which continent is known as the "Land Down Under"?</p>
          <input type="radio" id="q3a" name="q3" value="answer3">
          <label for="q3a">Africa</label><br>
          <input type="radio" id="q3b" name="q3" value="correct_answer3">
          <label for="q3b">Australia</label><br>

          <h2>Question 4</h2>
          <p>What is the capital of Japan?</p>
          <input type="radio" id="q4a" name="q4" value="answer4">
          <label for="q4a">Kyoto</label><br>
          <input type="radio" id="q4b" name="q4" value="correct_answer4">
          <label for="q4b">Tokyo</label><br>

          <h2>Question 5</h2>
          <p>What desert covers much of northern Africa?</p>
          <input type="radio" id="q5a" name="q5" value="answer5">
          <label for="q5a">Gobi Desert</label><br>
          <input type="radio" id="q5b" name="q5" value="correct_answer5">
          <label for="q5b">Sahara Desert</label><br>

          <h2>Question 6</h2>
          <p>Which country has the most natural lakes?</p>
          <input type="radio" id="q6a" name="q6" value="correct_answer6">
          <label for="q6a">Canada</label><br>
          <input type="radio" id="q6b" name="q6" value="answer6">
          <label for="q6b">Brazil</label><br>

          <h2>Question 7</h2>
          <p>Mount Everest lies on the border of Nepal and which other country?</p>
          <input type="radio" id="q7a" name="q7" value="answer7">
          <label for="q7a">India</label><br>
          <input type="radio" id="q7b" name="q7" value="correct_answer7">
          <label for="q7b">China</label><br>

          <h2>Question 8</h2>
          <p>What is the smallest country in the world?</p>
          <input type="radio" id="q8a" name="q8" value="answer8">
          <label for="q8a">Monaco</label><br>
          <input type="radio" id="q8b" name="q8" value="correct_answer8">
          <label for="q8b">Vatican City</label><br>

          <h2>Question 9</h2>
          <p>Which U.S. state has the longest coastline?</p>
          <input type="radio" id="q9a" name="q9" value="correct_answer9">
          <label for="q9a">Alaska</label><br>
          <input type="radio" id="q9b" name="q9" value="answer9">
          <label for="q9b">Florida</label><br>

          <h2>Question 10</h2>
          <p>What is the most populous country in Africa?</p>
          <input type="radio" id="q10a" name="q10" value="correct_answer10">
          <label for="q10a">Nigeria</label><br>
          <input type="radio" id="q10b" name="q10" value="answer10">
          <label for="q10b">Egypt</label><br>

          <!-- Submit button -->
          <button type="submit">Submit Quiz</button>
     </form>
</body>
</html>
