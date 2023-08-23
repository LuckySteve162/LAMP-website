// Inside the button click event listener
fetch('/script.php', {
    method: 'POST',
    body: JSON.stringify(data),
    headers: {
        'Content-Type': 'application/json'
    }
})
    .then(response => response.json())
    .then(data => {
        console.log(data.message);
        if (data.scoreboard) {
            // Display the top 10 users' scores
            scoreboard.innerHTML = '';
            data.scoreboard.forEach((entry, index) => {
                scoreboard.innerHTML += `<li>${entry.username}: ${entry.count}</li>`;
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
