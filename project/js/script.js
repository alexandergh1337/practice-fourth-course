const appData = {
    currentUser: null,
    recipes: [],
    comments: [],
    likes: []
};

document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
    setupEventListeners();
    loadSampleData();
    updateAuthUI();
    renderRecipes();
});

function initializeApp() {
    const savedUser = localStorage.getItem('currentUser');
    if (savedUser) {
        appData.currentUser = JSON.parse(savedUser);
    }
    
    const savedRecipes = localStorage.getItem('recipes');
    if (savedRecipes) {
        appData.recipes = JSON.parse(savedRecipes);
    } else {
        loadSampleData();
    }
    
    const savedComments = localStorage.getItem('comments');
    if (savedComments) {
        appData.comments = JSON.parse(savedComments);
    }
    
    const savedLikes = localStorage.getItem('likes');
    if (savedLikes) {
        appData.likes = JSON.parse(savedLikes);
    }
}

function loadSampleData() {
    if (appData.recipes.length === 0) {
        appData.recipes = [
            {
                id: 1,
                title: "Борщ",
                description: "Традиционный украинский суп с свеклой и мясом",
                cookingTime: 90,
                userId: 1,
                userName: "Иван Петров",
                createdAt: new Date('2025-05-15'),
                category: "обед",
                ingredients: [
                    { name: "свекла", quantity: "2", unit: "шт" },
                    { name: "картофель", quantity: "3", unit: "шт" },
                    { name: "морковь", quantity: "1", unit: "шт" },
                    { name: "лук", quantity: "1", unit: "шт" },
                    { name: "мясо", quantity: "500", unit: "г" }
                ],
                steps: [
                    { stepNumber: 1, instruction: "Нарезать овощи", imageUrl: "" },
                    { stepNumber: 2, instruction: "Обжарить лук и морковь", imageUrl: "" },
                    { stepNumber: 3, instruction: "Добавить свеклу и тушить", imageUrl: "" },
                    { stepNumber: 4, instruction: "Добавить мясо и картофель, варить 40 минут", imageUrl: "" }
                ]
            },
            {
                id: 2,
                title: "Чизкейк",
                description: "Нежный творожный десерт с ягодами",
                cookingTime: 120,
                userId: 2,
                userName: "Мария Сидорова",
                createdAt: new Date('2025-06-20'),
                category: "десерт",
                ingredients: [
                    { name: "творог", quantity: "500", unit: "г" },
                    { name: "сахар", quantity: "100", unit: "г" },
                    { name: "яйца", quantity: "3", unit: "шт" },
                    { name: "сливки", quantity: "200", unit: "мл" },
                    { name: "печенье", quantity: "200", unit: "г" }
                ],
                steps: [
                    { stepNumber: 1, instruction: "Измельчить печенье и смешать с маслом для основы", imageUrl: "" },
                    { stepNumber: 2, instruction: "Взбить творог с сахаром и яйцами", imageUrl: "" },
                    { stepNumber: 3, instruction: "Добавить сливки и перемешать", imageUrl: "" },
                    { stepNumber: 4, instruction: "Вылить в форму и выпекать 45 минут при 160°C", imageUrl: "" }
                ]
            },
            {
                id: 3,
                title: "Греческий салат",
                description: "Свежий салат с овощами и фетой",
                cookingTime: 15,
                userId: 1,
                userName: "Иван Петров",
                createdAt: new Date('2025-07-10'),
                category: "закуска",
                ingredients: [
                    { name: "томаты", quantity: "3", unit: "шт" },
                    { name: "огурцы", quantity: "2", unit: "шт" },
                    { name: "лук", quantity: "0.5", unit: "шт" },
                    { name: "оливки", quantity: "100", unit: "г" },
                    { name: "сыр фета", quantity: "150", unit: "г" }
                ],
                steps: [
                    { stepNumber: 1, instruction: "Нарезать овощи кубиками", imageUrl: "" },
                    { stepNumber: 2, instruction: "Добавить оливки и сыр фета", imageUrl: "" },
                    { stepNumber: 3, instruction: "Заправить оливковым маслом и специями", imageUrl: "" }
                ]
            }
        ];
        saveRecipesToStorage();
    }
}

function updateAuthUI() {
    const guestNav = document.getElementById('auth-nav-guest');
    const userNav = document.querySelectorAll('#auth-nav-user');
    const logoutNav = document.getElementById('auth-nav-logout');
    
    if (appData.currentUser) {
        if (guestNav) guestNav.style.display = 'none';
        userNav.forEach(item => item.style.display = 'block');
        if (logoutNav) logoutNav.style.display = 'block';
        
        document.getElementById('profile-link').textContent = appData.currentUser.username;
    } else {
        if (guestNav) guestNav.style.display = 'block';
        userNav.forEach(item => item.style.display = 'none');
        if (logoutNav) logoutNav.style.display = 'none';
    }
}

function setupEventListeners() {
    const loginLink = document.getElementById('login-link');
    if (loginLink) {
        loginLink.addEventListener('click', function(e) {
            e.preventDefault();
            showLoginModal();
        });
    }
    
    const logoutLink = document.getElementById('logout-link');
    if (logoutLink) {
        logoutLink.addEventListener('click', function(e) {
            e.preventDefault();
            logout();
        });
    }
    
    const createRecipeLink = document.getElementById('create-recipe-link');
    if (createRecipeLink) {
        createRecipeLink.addEventListener('click', function(e) {
            e.preventDefault();
            if (appData.currentUser) {
                showAddRecipeModal();
            } else {
                alert('Для добавления рецепта необходимо войти в аккаунт');
            }
        });
    }
    
    const profileLink = document.getElementById('profile-link');
    if (profileLink) {
        profileLink.addEventListener('click', function(e) {
            e.preventDefault();
            if (appData.currentUser) {
                document.getElementById('recipe-feed').querySelector('h2').textContent = 'Персонализированная лента';
                renderRecipes(true);
            }
        });
    }
    
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleLogin();
        });
    }
    
    const loginSubmit = document.getElementById('login-submit');
    if (loginSubmit) {
        loginSubmit.addEventListener('click', handleLogin);
    }
    
    const recipeForm = document.getElementById('recipe-form');
    if (recipeForm) {
        recipeForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleAddRecipe();
        });
    }
    
    const submitRecipe = document.getElementById('submit-recipe');
    if (submitRecipe) {
        submitRecipe.addEventListener('click', handleAddRecipe);
    }
    
    const addIngredientBtn = document.getElementById('add-ingredient');
    if (addIngredientBtn) {
        addIngredientBtn.addEventListener('click', addIngredientInput);
    }
    
    const addStepBtn = document.getElementById('add-step');
    if (addStepBtn) {
        addStepBtn.addEventListener('click', addStepInput);
    }
    
    const exploreBtn = document.getElementById('explore-btn');
    if (exploreBtn) {
        exploreBtn.addEventListener('click', function() {
            document.getElementById('recipe-feed').scrollIntoView({ behavior: 'smooth' });
        });
    }
    
    const searchInput = document.getElementById('search-input');
    if (searchInput) {
        searchInput.addEventListener('input', applyFilters);
    }
    
    const categoryFilter = document.getElementById('category-filter');
    if (categoryFilter) {
        categoryFilter.addEventListener('change', applyFilters);
    }
    
    const ingredientFilter = document.getElementById('ingredient-filter');
    if (ingredientFilter) {
        ingredientFilter.addEventListener('input', applyFilters);
    }
    
    const homeLink = document.getElementById('home-link');
    if (homeLink) {
        homeLink.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('recipe-feed').querySelector('h2').textContent = 'Популярные рецепты';
            renderRecipes();
        });
    }
    
    const exploreLink = document.getElementById('explore-link');
    if (exploreLink) {
        exploreLink.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('recipe-feed').querySelector('h2').textContent = 'Все рецепты';
            renderRecipes();
        });
    }
}

function showLoginModal() {
    const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
    loginModal.show();
}

function handleLogin() {
    const email = document.getElementById('login-email').value;
    const password = document.getElementById('login-password').value;
    
    if (email && password) {
        const user = {
            id: Date.now(),
            username: email.split('@')[0],
            email: email
        };
        
        appData.currentUser = user;
        localStorage.setItem('currentUser', JSON.stringify(user));
        updateAuthUI();
        
        const modal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
        if (modal) {
            modal.hide();
        }
        
        document.getElementById('login-form').reset();
        
        alert('Успешный вход!');
    } else {
        alert('Пожалуйста, заполните все поля');
    }
}

function logout() {
    appData.currentUser = null;
    localStorage.removeItem('currentUser');
    updateAuthUI();
    document.getElementById('recipe-feed').querySelector('h2').textContent = 'Популярные рецепты';
    renderRecipes();
    alert('Вы вышли из аккаунта');
}

function showAddRecipeModal() {
    document.getElementById('recipe-form').reset();
    
    const ingredientsContainer = document.getElementById('ingredients-container');
    ingredientsContainer.innerHTML = `
        <article class="ingredient-input mb-2">
            <article class="row">
                <article class="col-md-6">
                    <input type="text" class="form-control ingredient-name" placeholder="Название ингредиента">
                </article>
                <article class="col-md-3">
                    <input type="text" class="form-control ingredient-quantity" placeholder="Количество">
                </article>
                <article class="col-md-3">
                    <input type="text" class="form-control ingredient-unit" placeholder="Единица измерения">
                </article>
            </article>
        </article>
    `;
    
    const stepsContainer = document.getElementById('steps-container');
    stepsContainer.innerHTML = `
        <article class="step-input mb-2">
            <textarea class="form-control step-description" placeholder="Описание шага" rows="2"></textarea>
            <input type="file" class="form-control step-image mt-1" accept="image/*">
        </article>
    `;
    
    const addRecipeModal = new bootstrap.Modal(document.getElementById('addRecipeModal'));
    addRecipeModal.show();
}

function addIngredientInput() {
    const container = document.getElementById('ingredients-container');
    const newIngredient = document.createElement('article');
    newIngredient.className = 'ingredient-input mb-2';
    newIngredient.innerHTML = `
        <article class="row">
            <article class="col-md-6">
                <input type="text" class="form-control ingredient-name" placeholder="Название ингредиента">
            </article>
            <article class="col-md-3">
                <input type="text" class="form-control ingredient-quantity" placeholder="Количество">
            </article>
            <article class="col-md-3">
                <input type="text" class="form-control ingredient-unit" placeholder="Единица измерения">
            </article>
        </article>
    `;
    container.appendChild(newIngredient);
}

function addStepInput() {
    const container = document.getElementById('steps-container');
    const newStep = document.createElement('article');
    newStep.className = 'step-input mb-2';
    newStep.innerHTML = `
        <textarea class="form-control step-description" placeholder="Описание шага" rows="2"></textarea>
        <input type="file" class="form-control step-image mt-1" accept="image/*">
    `;
    container.appendChild(newStep);
}

function handleAddRecipe() {
    if (!appData.currentUser) {
        alert('Для добавления рецепта необходимо войти в аккаунт');
        return;
    }
    
    const title = document.getElementById('recipe-title').value;
    const description = document.getElementById('recipe-description').value;
    const cookingTime = document.getElementById('recipe-time').value;
    const category = document.getElementById('recipe-category').value;
    
    if (!title || !description || !cookingTime) {
        alert('Пожалуйста, заполните все обязательные поля');
        return;
    }
    
    const ingredients = [];
    const ingredientInputs = document.querySelectorAll('.ingredient-input');
    ingredientInputs.forEach(input => {
        const name = input.querySelector('.ingredient-name').value;
        const quantity = input.querySelector('.ingredient-quantity').value;
        const unit = input.querySelector('.ingredient-unit').value;
        
        if (name) {
            ingredients.push({
                name: name,
                quantity: quantity,
                unit: unit
            });
        }
    });
    
    const steps = [];
    const stepInputs = document.querySelectorAll('.step-input');
    stepInputs.forEach((input, index) => {
        const instruction = input.querySelector('.step-description').value;
        
        if (instruction) {
            steps.push({
                stepNumber: index + 1,
                instruction: instruction,
                imageUrl: ''
            });
        }
    });
    
    if (steps.length === 0) {
        alert('Пожалуйста, добавьте хотя бы один шаг приготовления');
        return;
    }
    
    const newRecipe = {
        id: Date.now(),
        title: title,
        description: description,
        cookingTime: parseInt(cookingTime),
        userId: appData.currentUser.id,
        userName: appData.currentUser.username,
        createdAt: new Date(),
        category: category,
        ingredients: ingredients,
        steps: steps
    };
    
    appData.recipes.push(newRecipe);
    saveRecipesToStorage();
    
    const modal = bootstrap.Modal.getInstance(document.getElementById('addRecipeModal'));
    if (modal) {
        modal.hide();
    }
    
    renderRecipes();
    
    alert('Рецепт успешно добавлен!');
}

function saveRecipesToStorage() {
    localStorage.setItem('recipes', JSON.stringify(appData.recipes));
}

function applyFilters() {
    const isPersonalized = document.getElementById('recipe-feed').querySelector('h2').textContent === 'Персонализированная лента';
    renderRecipes(isPersonalized);
}

function getFilteredRecipes() {
    const searchQuery = document.getElementById('search-input').value.toLowerCase();
    const categoryFilter = document.getElementById('category-filter').value;
    const ingredientQuery = document.getElementById('ingredient-filter').value.toLowerCase();
    
    return appData.recipes.filter(recipe => {
        const matchesSearch = !searchQuery || 
            recipe.title.toLowerCase().includes(searchQuery) || 
            recipe.description.toLowerCase().includes(searchQuery);
        
        const matchesCategory = !categoryFilter || recipe.category === categoryFilter;
        
        let matchesIngredients = true;
        if (ingredientQuery) {
            const ingredients = ingredientQuery.split(',').map(i => i.trim()).filter(i => i);
            if (ingredients.length > 0) {
                matchesIngredients = ingredients.some(ingredient => 
                    recipe.ingredients.some(ing => 
                        ing.name.toLowerCase().includes(ingredient)
                    )
                );
            }
        }
        
        return matchesSearch && matchesCategory && matchesIngredients;
    });
}

function getPersonalizedRecipes() {
    if (!appData.currentUser) {
        return getPopularRecipes();
    }
    
    const userInteractions = [];
    
    appData.likes
        .filter(like => like.userId === appData.currentUser.id)
        .forEach(like => {
            if (!userInteractions.includes(like.recipeId)) {
                userInteractions.push(like.recipeId);
            }
        });
    
    appData.comments
        .filter(comment => comment.userId === appData.currentUser.id)
        .forEach(comment => {
            if (!userInteractions.includes(comment.recipeId)) {
                userInteractions.push(comment.recipeId);
            }
        });
    
    const similarRecipes = [];
    const userLikedRecipes = appData.recipes.filter(recipe => 
        userInteractions.includes(recipe.id)
    );
    
    const likedIngredients = [];
    userLikedRecipes.forEach(recipe => {
        recipe.ingredients.forEach(ingredient => {
            if (!likedIngredients.includes(ingredient.name.toLowerCase())) {
                likedIngredients.push(ingredient.name.toLowerCase());
            }
        });
    });
    
    appData.recipes.forEach(recipe => {
        if (!userInteractions.includes(recipe.id)) {
            const hasSimilarIngredients = recipe.ingredients.some(ing => 
                likedIngredients.includes(ing.name.toLowerCase())
            );
            
            if (hasSimilarIngredients && !similarRecipes.includes(recipe.id)) {
                similarRecipes.push(recipe.id);
            }
        }
    });
    
    const popularRecipes = getPopularRecipes().slice(0, 5).map(r => r.id);
    
    const combinedRecipeIds = [...userInteractions, ...similarRecipes, ...popularRecipes];
    
    const uniqueRecipeIds = [...new Set(combinedRecipeIds)];
    
    return uniqueRecipeIds.map(id => appData.recipes.find(r => r.id === id)).filter(r => r);
}

function getPopularRecipes() {
    return [...appData.recipes].sort((a, b) => {
        const aLikes = appData.likes.filter(like => like.recipeId === a.id).length;
        const bLikes = appData.likes.filter(like => like.recipeId === b.id).length;
        return bLikes - aLikes;
    });
}

function renderRecipes(isPersonalized = false) {
    const container = document.getElementById('recipes-container');
    if (!container) return;
    
    let recipes;
    if (isPersonalized) {
        recipes = getPersonalizedRecipes();
    } else {
        recipes = getFilteredRecipes();
    }
    
    container.innerHTML = '';
    
    if (recipes.length === 0) {
        container.innerHTML = '<article class="col-12"><p class="text-center">Рецепты не найдены</p></article>';
        return;
    }
    
    const fragment = document.createDocumentFragment();
    
    recipes.forEach(recipe => {
        const recipeCard = createRecipeCard(recipe);
        fragment.appendChild(recipeCard);
    });
    
    container.appendChild(fragment);
}

function createRecipeCard(recipe) {
    const col = document.createElement('article');
    col.className = 'col-md-4 mb-4';
    
    const recipeLikes = appData.likes.filter(like => like.recipeId === recipe.id);
    const likeCount = recipeLikes.length;
    const userLiked = appData.currentUser ? recipeLikes.some(like => like.userId === appData.currentUser.id) : false;
    
    col.innerHTML = `
        <article class="card recipe-card h-100">
            <article class="card-body d-flex flex-column">
                <h5 class="card-title">${recipe.title}</h5>
                <p class="card-text">${recipe.description}</p>
                <article class="mt-auto">
                    <article class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="bi bi-clock"></i> ${recipe.cookingTime} мин
                        </small>
                        <small class="text-muted">
                            <i class="bi bi-person"></i> ${recipe.userName}
                        </small>
                    </article>
                    <article class="mt-2">
                        <span class="badge bg-secondary">${recipe.category}</span>
                    </article>
                    <article class="mt-3 d-flex justify-content-between">
                        <button class="btn btn-sm btn-outline-primary view-recipe-btn" data-recipe-id="${recipe.id}">
                            <i class="bi bi-eye"></i> Просмотр
                        </button>
                        <button class="btn btn-sm ${userLiked ? 'btn-danger' : 'btn-outline-danger'} like-btn" data-recipe-id="${recipe.id}">
                            <i class="bi ${userLiked ? 'bi-heart-fill' : 'bi-heart'}"></i> <span class="like-count">${likeCount}</span>
                        </button>
                    </article>
                </article>
            </article>
        </article>
    `;
    
    const viewBtn = col.querySelector('.view-recipe-btn');
    viewBtn.addEventListener('click', () => showRecipeDetails(recipe.id));
    
    const likeBtn = col.querySelector('.like-btn');
    likeBtn.addEventListener('click', (e) => toggleLike(e, recipe.id));
    
    return col;
}

function showRecipeDetails(recipeId) {
    const recipe = appData.recipes.find(r => r.id === recipeId);
    if (!recipe) return;
    
    let ingredientsHtml = '<ul class="list-group list-group-flush">';
    recipe.ingredients.forEach(ing => {
        ingredientsHtml += `<li class="list-group-item">${ing.quantity} ${ing.unit} ${ing.name}</li>`;
    });
    ingredientsHtml += '</ul>';
    
    let stepsHtml = '<ol class="list-group list-group-numbered">';
    recipe.steps.forEach(step => {
        stepsHtml += `<li class="list-group-item">${step.instruction}</li>`;
    });
    stepsHtml += '</ol>';
    
    const recipeComments = appData.comments.filter(comment => comment.recipeId === recipe.id);
    let commentsHtml = '<article class="comment-section">';
    commentsHtml += '<h5>Комментарии</h5>';
    
    if (recipeComments.length > 0) {
        recipeComments.forEach(comment => {
            commentsHtml += `
                <article class="card mb-2">
                    <article class="card-body">
                        <article class="d-flex justify-content-between">
                            <h6 class="card-subtitle mb-2 text-muted">${comment.userName}</h6>
                            <small class="text-muted">${new Date(comment.createdAt).toLocaleString()}</small>
                        </article>
                        <p class="card-text">${comment.text}</p>
                    </article>
                </article>
            `;
        });
    } else {
        commentsHtml += '<p class="text-muted">Комментариев пока нет</p>';
    }
    
    if (appData.currentUser) {
        commentsHtml += `
            <article class="mt-3">
                <textarea class="form-control" id="comment-text-${recipe.id}" placeholder="Добавьте комментарий..." rows="3"></textarea>
                <button class="btn btn-primary btn-sm mt-2 add-comment-btn" data-recipe-id="${recipe.id}">Комментировать</button>
            </article>
        `;
    } else {
        commentsHtml += '<p class="text-muted">Войдите, чтобы оставить комментарий</p>';
    }
    
    commentsHtml += '</article>';
    
    document.getElementById('recipeModalTitle').textContent = recipe.title;
    document.getElementById('recipeModalBody').innerHTML = `
        <article class="recipe-details">
            <p><strong>Описание:</strong> ${recipe.description}</p>
            <p><strong>Время приготовления:</strong> ${recipe.cookingTime} минут</p>
            <p><strong>Категория:</strong> ${recipe.category}</p>
            <p><strong>Автор:</strong> ${recipe.userName}</p>
            
            <h4>Ингредиенты:</h4>
            ${ingredientsHtml}
            
            <h4 class="mt-4">Шаги приготовления:</h4>
            ${stepsHtml}
            
            ${commentsHtml}
        </article>
    `;
    
    const addCommentBtn = document.querySelector(`.add-comment-btn[data-recipe-id="${recipe.id}"]`);
    if (addCommentBtn) {
        addCommentBtn.addEventListener('click', () => addComment(recipe.id));
    }
    
    const recipeModal = new bootstrap.Modal(document.getElementById('recipeModal'));
    recipeModal.show();
}

function addComment(recipeId) {
    if (!appData.currentUser) {
        alert('Для добавления комментария необходимо войти в аккаунт');
        return;
    }
    
    const commentText = document.getElementById(`comment-text-${recipeId}`).value;
    if (!commentText.trim()) {
        alert('Комментарий не может быть пустым');
        return;
    }
    
    const newComment = {
        id: Date.now(),
        recipeId: recipeId,
        userId: appData.currentUser.id,
        userName: appData.currentUser.username,
        text: commentText,
        createdAt: new Date()
    };
    
    appData.comments.push(newComment);
    localStorage.setItem('comments', JSON.stringify(appData.comments));
    
    showRecipeDetails(recipeId);
    
    document.getElementById(`comment-text-${recipeId}`).value = '';
}

function toggleLike(event, recipeId) {
    if (!appData.currentUser) {
        alert('Для лайка рецепта необходимо войти в аккаунт');
        return;
    }
    
    const button = event.target.closest('.like-btn');
    const icon = button.querySelector('i');
    const countSpan = button.querySelector('.like-count');
    
    const existingLike = appData.likes.find(like => 
        like.userId === appData.currentUser.id && like.recipeId === recipeId
    );
    
    if (existingLike) {
        appData.likes = appData.likes.filter(like => like.id !== existingLike.id);
        icon.className = 'bi bi-heart';
        button.classList.remove('btn-danger');
        button.classList.add('btn-outline-danger');
    } else {
        const newLike = {
            id: Date.now(),
            userId: appData.currentUser.id,
            recipeId: recipeId
        };
        appData.likes.push(newLike);
        icon.className = 'bi bi-heart-fill';
        button.classList.remove('btn-outline-danger');
        button.classList.add('btn-danger');
    }
    
    const recipeLikes = appData.likes.filter(like => like.recipeId === recipeId);
    countSpan.textContent = recipeLikes.length;
    
    localStorage.setItem('likes', JSON.stringify(appData.likes));
}