// snowfall.js

document.addEventListener("DOMContentLoaded", function () {
    const snowflakesContainer = document.createElement("div");
    snowflakesContainer.className = "snowflakes";
    snowflakesContainer.setAttribute("aria-hidden", "true");
    document.body.appendChild(snowflakesContainer);

    for (let i = 0; i < 50; i++) {
        const snowflake = document.createElement("div");
        snowflake.className = "snowflake";
        snowflake.style.left = `${Math.random() * 100}vw`;
        snowflake.style.animationDuration = `${Math.random() * 2 + 1}s`;
        snowflake.style.animationDelay = `${Math.random()}s`;
        snowflakesContainer.appendChild(snowflake);
    }
});
