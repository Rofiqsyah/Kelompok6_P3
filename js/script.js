document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Mencegah reload halaman

    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;

    if (email === "admin@tecocell.com" && password === "123456") {
        alert("Login berhasil!");
        window.location.href = "dashboard.html"; // Ganti dengan halaman tujuan setelah login
    } else {
        alert("Email atau password salah!");
    }
});