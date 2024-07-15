function fetch_data() {
    const date = document.getElementById('date_picker').value;
    if (!date) return;  

    fetch(`fetch_mood.php?date=${date}`)
        .then(response => response.json())
        .then(data => {
            const mood_counts_div = document.getElementById('mood_counts');
            if (data.length === 0) {
                console.warn('No mood data available for the selected date.');
                mood_counts_div.innerHTML = '<p>No mood data available for the selected date.</p>';
                if (window.my_pie_chart) {
                    window.my_pie_chart.destroy();
                }
                return;
            }

            const labels = data.map(item => item.mood);
            const values = data.map(item => item.count);

            const colors = getComputedStyle(document.documentElement)
                .getPropertyValue('--chart-colors')
                .trim()
                .split(',');

            const ctx = document.getElementById('my_chart').getContext('2d');
            if (window.my_pie_chart) {
                window.my_pie_chart.destroy();
            }
            window.my_pie_chart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: colors
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: `Mood Reactions on ${date}`
                    }
                }
            });

            mood_counts_div.innerHTML = '';
            data.forEach(item => {
                const p = document.createElement('p');
                p.textContent = `During this day, there are ${item.count} people that are ${item.mood}`;
                mood_counts_div.appendChild(p);
            });
        })
        .catch(error => console.error('Error fetching data:', error));
}
