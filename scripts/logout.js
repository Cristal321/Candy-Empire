document.getElementById("logoutButton").addEventListener("click", function () {
    // Показываем поп-ап для подтверждения
    document.getElementById("exitPopup").style.display = "flex";
});

document.getElementById("closeExitPopup").addEventListener("click", function () {
    // Закрываем поп-ап
    document.getElementById("exitPopup").style.display = "none";
});

document.getElementById("exit_etot").addEventListener("click", async function () {
    // Выход только из текущего устройства
    try {
        const response = await fetch("../api/logout.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
        });

        const result = await response.json();
        console.log(result);

        if (result.status === "success") {
            window.location.href = "../php/authorization.php"; // Перенаправляем на страницу входа
        }
    } catch (error) {
        console.error("Ошибка при выходе:", error);
        alert("Ошибка выхода, попробуйте снова.");
    }
    
    // Закрываем поп-ап после действия
    document.getElementById("exitPopup").style.display = "none";
});

document.getElementById("Exit_vsex").addEventListener("click", async function () {
    // Выход со всех устройств
    try {
        const response = await fetch("../api/logout_from_all_devices.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
        });

        const result = await response.json();
        console.log(result);

        if (result.status === "success") {
            window.location.href = "../php/authorization.php"; // Перенаправляем на страницу входа
        }
    } catch (error) {
        console.error("Ошибка при выходе:", error);
        alert("Ошибка выхода, попробуйте снова.");
    }

    // Закрываем поп-ап после действия
    document.getElementById("exitPopup").style.display = "none";
});
