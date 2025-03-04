document.getElementById("change-password-form").addEventListener("submit", async function (event) {
    event.preventDefault(); // Предотвращаем отправку формы
  
    const login = document.getElementById("login").value;
    const oldPassword = document.getElementById("password").value;
    const newPassword = document.getElementById("newpassword").value;
    const errorPopup = document.getElementById("ErrorPopup"); // Попап ошибки
    const errorMessage = errorPopup.querySelector("p"); // Сообщение ошибки
    const closeErrorPopup = document.getElementById("closeErrorPopup"); // Кнопка закрытия (исправлено!)


  
    try {
      const response = await fetch("../api/change_parol.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({
          login: login,
          old_password: oldPassword,
          new_password: newPassword,
        }),
      });
  
      const result = await response.json();
      console.log(result); // Для проверки в консоли
  
      //alert(result.message); // Показываем сообщение пользователю
  
      if (result.status === "success") {
        window.location.href = "../php/authorization.php"; // Перенаправляем на страницу входа
      }

      if (result.status === "error") {
        errorMessage.textContent = result.message;
        errorPopup.style.display = "flex";
        //alert(result.message);
    }



    } catch (error) {
      console.error("Ошибка при смене пароля:", error);
      alert("Ошибка при смене пароля, попробуйте снова.");
    }


    closeErrorPopup.addEventListener("click", function () {
      errorPopup.style.display = "none";
  });
  
  window.addEventListener("click", function (event) {
      if (event.target === errorPopup) {
          errorPopup.style.display = "none";
      }
  });



});
  