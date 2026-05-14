const WHATSAPP_NUMBER = "<?= $whatsapp ?>";

const menuBtn = document.getElementById("menuBtn");
const mobileMenu = document.getElementById("mobileMenu");

menuBtn.addEventListener("click", () => {
    mobileMenu.classList.toggle("hidden");
});

let guests = 6;
let rooms = 1;

const guestsText = document.getElementById("guests");
const roomsText = document.getElementById("rooms");

document.querySelector(".guestPlus").addEventListener("click", () => {
    guests++;
    guestsText.textContent = guests;
});

document.querySelector(".guestMinus").addEventListener("click", () => {
    if (guests > 1) {
        guests--;
        guestsText.textContent = guests;
    }
});

document.querySelector(".roomPlus").addEventListener("click", () => {
    rooms++;
    roomsText.textContent = rooms;
});

document.querySelector(".roomMinus").addEventListener("click", () => {
    if (rooms > 1) {
        rooms--;
        roomsText.textContent = rooms;
    }
});

const searchInput = document.getElementById("searchInput");
const yachtCards = document.querySelectorAll(".yachtCard");

searchInput.addEventListener("input", () => {
    const value = searchInput.value.toLowerCase();

    yachtCards.forEach(card => {
        const text = card.innerText.toLowerCase();

        if (text.includes(value)) {
            card.classList.remove("hidden");
        } else {
            card.classList.add("hidden");
        }
    });
});

const filterBtns = document.querySelectorAll(".filterBtn");

filterBtns.forEach(btn => {
    btn.addEventListener("click", () => {
        filterBtns.forEach(item => {
            item.classList.remove("bg-teal", "text-white", "activeFilter");
            item.classList.add("bg-white", "border", "border-gray-300");
        });

        btn.classList.add("bg-teal", "text-white", "activeFilter");
        btn.classList.remove("bg-white", "border", "border-gray-300");
    });
});

const bookingForm = document.getElementById("bookingForm");
const formMsg = document.getElementById("formMsg");

bookingForm.addEventListener("submit", (e) => {
    e.preventDefault();

    const name = document.getElementById("name").value.trim();
    const phone = document.getElementById("phone").value.trim();
    const boatType = document.getElementById("boatType").value.trim();

    if (!name || !phone || !boatType) {
        formMsg.textContent = "Rellena todos los campos.";
        formMsg.className = "block text-sm font-bold text-red-600";
        return;
    }

    const message = `Hola, quiero reservar un yate.%0A%0ANombre: ${name}%0ATeléfono: ${phone}%0ATipo de yate: ${boatType}%0ALugar: Marina Smir`;
    window.open(`https://wa.me/${WHATSAPP_NUMBER}?text=${message}`, "_blank");
});
