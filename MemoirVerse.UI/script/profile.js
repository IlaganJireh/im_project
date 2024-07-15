document.addEventListener('DOMContentLoaded', () => {
    fetchUserProfile();
});

async function fetchUserProfile() {
    try {
        const response = await fetch('getUserProfile.php');
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        if (data && data.firstName && data.lastName && data.user_id) {
            document.getElementById('profile-name').textContent = `${data.firstName} ${data.lastName}`;
            document.getElementById('profile-username').textContent = `@${data.user_id}`;
        } else {
            console.error('Invalid data format', data);
        }
    } catch (error) {
        console.error('Error fetching user profile:', error);
    }
}
