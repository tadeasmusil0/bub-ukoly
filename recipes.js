// Demo data - recepty
const recipes = [
    { name: "Pasta Carbonara", cuisine: "italian", time: "short", description: "Creamy pasta dish with bacon and Parmesan cheese." },
    { name: "Sushi Rolls", cuisine: "asian", time: "medium", description: "Traditional Japanese sushi rolls with rice, fish, and vegetables." },
    { name: "Chicken Parmesan", cuisine: "italian", time: "medium", description: "Breaded chicken breasts topped with marinara sauce and melted cheese." },
    { name: "Pad Thai", cuisine: "asian", time: "medium", description: "Stir-fried rice noodles with shrimp, tofu, peanuts, and vegetables." }
    // Další recepty...
];

// Funkce pro vykreslení receptů
function renderRecipes(recipes) {
    const recipesContainer = document.querySelector('.recipes');
    recipesContainer.innerHTML = '';

    recipes.forEach(recipe => {
        const recipeCard = document.createElement('div');
        recipeCard.classList.add('recipe');
        recipeCard.innerHTML = `
            <h3>${recipe.name}</h3>
            <p>Kitchen: ${capitalizeFirstLetter(recipe.cuisine)}</p>
            <p>Preparation Time: ${capitalizeFirstLetter(recipe.time)}</p>
            <p>${recipe.description}</p>
        `;
        recipesContainer.appendChild(recipeCard);
    });
}

// Funkce pro filtrování receptů
function filterRecipes() {
    const cuisineFilter = document.getElementById('cuisine').value;
    const timeFilter = document.getElementById('time').value;

    let filteredRecipes = recipes;

    if (cuisineFilter !== 'all') {
        filteredRecipes = filteredRecipes.filter(recipe => recipe.cuisine === cuisineFilter);
    }

    if (timeFilter !== 'all') {
        filteredRecipes = filteredRecipes.filter(recipe => recipe.time === timeFilter);
    }

    renderRecipes(filteredRecipes);
}

// Pomocná funkce pro velké počáteční písmeno
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

// Nastavení posluchačů událostí
document.getElementById('cuisine').addEventListener('change', filterRecipes);
document.getElementById('time').addEventListener('change', filterRecipes);

// Po načtení stránky zavolat funkci pro zobrazení všech receptů
window.onload = function () {
    renderRecipes(recipes);
};
