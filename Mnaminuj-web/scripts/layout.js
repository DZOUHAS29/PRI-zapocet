document.addEventListener("DOMContentLoaded", () => {
    fetch("/components/header.php")
        .then(res => res.text())
        .then(data => {
            document.getElementById("header").innerHTML = data;

            document.getElementById("profile").addEventListener("click", () => {
                const logout = window.confirm("Chcete se odhlásit?")

                if (logout)
                    fetch("/server/logout.php")
                        .then(res => window.location.href = "/index.php")
                        .catch(err => console.error(err));
            });
        })
        .catch(err => {
            console.log(err);
        });

});