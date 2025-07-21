<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Diet & Nutrition | BabyCare</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <style>
      :root {
        --baby-pink: #ffb6c1;
        --baby-blue: #89cff0;
        --baby-green: #98ff98;
        --baby-lavender: #e6e6fa;
        --baby-orange: #ffb347;
        --header-gradient: linear-gradient(
          135deg,
          var(--baby-pink),
          var(--baby-blue)
        );
      }

      body {
        background-color: #fff9f9;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      }

      .nutrition-header {
        background: linear-gradient(135deg, #b6e5d8, var(--baby-blue));
        color: white;
        border-radius: 0 0 25px 25px;
        padding: 20px 0;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
      }

      .baby-avatar {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        border: 3px solid white;
        object-fit: cover;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      }

      .btn-back {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 1px solid white;
        border-radius: 50px;
        padding: 8px 16px;
        font-weight: 500;
        transition: all 0.3s;
        backdrop-filter: blur(5px);
        display: inline-flex;
        align-items: center;
        text-decoration: none;
      }

      .btn-back:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        color: white;
      }

      .nutrition-card {
        background-color: white;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
      }

      .intake-card {
        background-color: white;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 15px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        border-left: 4px solid var(--baby-orange);
      }

      .nutrition-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        margin-right: 8px;
        margin-bottom: 8px;
      }

      .progress-thin {
        height: 6px;
        border-radius: 3px;
      }

      .food-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: rgba(255, 179, 71, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--baby-orange);
        font-size: 1.2rem;
      }

      .meal-card {
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 15px;
        background-color: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: all 0.3s;
      }

      .meal-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      }

      .btn-nutrition {
        background: var(--header-gradient);
        color: white;
        border: none;
        border-radius: 50px;
        padding: 8px 20px;
        font-weight: 500;
        transition: all 0.3s;
      }

      .btn-nutrition:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      }

      .nav-tabs .nav-link {
        border: none;
        color: #666;
        font-weight: 500;
        padding: 12px 20px;
      }

      .nav-tabs .nav-link.active {
        color: var(--baby-orange);
        border-bottom: 3px solid var(--baby-orange);
        background: transparent;
      }

      .tab-content {
        padding: 20px 0;
      }

      .nutrition-fact {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
      }

      .timeline-item {
        position: relative;
        padding-left: 30px;
        margin-bottom: 20px;
      }

      .timeline-dot {
        position: absolute;
        left: 8px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: var(--baby-orange);
      }

      .timeline-connector {
        position: absolute;
        left: 13px;
        top: 17px;
        bottom: -25px;
        width: 2px;
        background-color: #eee;
      }

      @media (max-width: 768px) {
        .food-icon {
          width: 35px;
          height: 35px;
          font-size: 1rem;
        }
      }
    </style>
  </head>
  <body>
    <!-- Header Section -->
    <div class="nutrition-header">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <div class="d-flex align-items-center">
            <a href="dashboard.html" class="btn-back me-3">
              <i class="fas fa-arrow-left me-2"></i> Dashboard
            </a>
            <img
              src="https://cdn-icons-png.flaticon.com/512/1864/1864593.png"
              alt="Baby"
              class="baby-avatar me-3"
            />
            <div>
              <h2 class="mb-1 text-white">Emma Johnson</h2>
              <div class="d-flex align-items-center">
                <span class="text-white">
                  <i class="fas fa-utensils me-1"></i>
                  Diet & Nutrition
                </span>
              </div>
            </div>
          </div>
          <div>
            <span class="badge bg-white text-dark">
              <i
                class="fas fa-birthday-cake me-1"
                style="color: var(--baby-orange)"
              ></i>
              10 months old
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="container">
      <div class="nutrition-card">
        <ul class="nav nav-tabs" id="nutritionTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button
              class="nav-link active"
              id="today-tab"
              data-bs-toggle="tab"
              data-bs-target="#today"
              type="button"
              role="tab"
            >
              <i class="fas fa-calendar-day me-1"></i> Today
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button
              class="nav-link"
              id="schedule-tab"
              data-bs-toggle="tab"
              data-bs-target="#schedule"
              type="button"
              role="tab"
            >
              <i class="fas fa-clock me-1"></i> Feeding Schedule
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button
              class="nav-link"
              id="foods-tab"
              data-bs-toggle="tab"
              data-bs-target="#foods"
              type="button"
              role="tab"
            >
              <i class="fas fa-carrot me-1"></i> Food Library
            </button>
          </li>
        </ul>

        <div class="tab-content" id="nutritionTabContent">
          <!-- Today's Intake Tab -->
          <div class="tab-pane fade show active" id="today" role="tabpanel">
            <div class="row mb-4">
              <div class="col-md-6">
                <h5 class="mb-3">
                  <i
                    class="fas fa-fire me-2"
                    style="color: var(--baby-orange)"
                  ></i
                  >Daily Nutrition
                </h5>
                <div class="intake-card">
                  <div class="nutrition-fact">
                    <span>Calories</span>
                    <span><strong>680</strong>/900 kcal</span>
                  </div>
                  <div class="progress progress-thin mb-3">
                    <div
                      class="progress-bar"
                      role="progressbar"
                      style="width: 75%; background-color: var(--baby-orange)"
                    ></div>
                  </div>

                  <div class="nutrition-fact">
                    <span>Protein</span>
                    <span><strong>18g</strong>/25g</span>
                  </div>
                  <div class="progress progress-thin mb-3">
                    <div
                      class="progress-bar"
                      role="progressbar"
                      style="width: 72%; background-color: var(--baby-blue)"
                    ></div>
                  </div>

                  <div class="nutrition-fact">
                    <span>Carbs</span>
                    <span><strong>85g</strong>/110g</span>
                  </div>
                  <div class="progress progress-thin mb-3">
                    <div
                      class="progress-bar"
                      role="progressbar"
                      style="width: 77%; background-color: var(--baby-green)"
                    ></div>
                  </div>

                  <div class="nutrition-fact">
                    <span>Fats</span>
                    <span><strong>32g</strong>/40g</span>
                  </div>
                  <div class="progress progress-thin">
                    <div
                      class="progress-bar"
                      role="progressbar"
                      style="width: 80%; background-color: var(--baby-pink)"
                    ></div>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <h5 class="mb-3">
                  <i
                    class="fas fa-check-circle me-2"
                    style="color: var(--baby-green)"
                  ></i
                  >Today's Goals
                </h5>
                <div class="intake-card">
                  <div class="d-flex align-items-center mb-3">
                    <div class="food-icon me-3">
                      <i class="fas fa-wine-bottle"></i>
                    </div>
                    <div class="flex-grow-1">
                      <div class="d-flex justify-content-between">
                        <strong>Formula/Breast Milk</strong>
                        <span>450ml/600ml</span>
                      </div>
                      <div class="progress progress-thin mt-1">
                        <div
                          class="progress-bar"
                          role="progressbar"
                          style="width: 75%; background-color: var(--baby-blue)"
                        ></div>
                      </div>
                    </div>
                  </div>

                  <div class="d-flex align-items-center mb-3">
                    <div class="food-icon me-3">
                      <i class="fas fa-apple-alt"></i>
                    </div>
                    <div class="flex-grow-1">
                      <div class="d-flex justify-content-between">
                        <strong>Solid Foods</strong>
                        <span>3/4 meals</span>
                      </div>
                      <div class="progress progress-thin mt-1">
                        <div
                          class="progress-bar"
                          role="progressbar"
                          style="
                            width: 75%;
                            background-color: var(--baby-green);
                          "
                        ></div>
                      </div>
                    </div>
                  </div>

                  <div class="d-flex align-items-center">
                    <div class="food-icon me-3">
                      <i class="fas fa-tint"></i>
                    </div>
                    <div class="flex-grow-1">
                      <div class="d-flex justify-content-between">
                        <strong>Water</strong>
                        <span>120ml/200ml</span>
                      </div>
                      <div class="progress progress-thin mt-1">
                        <div
                          class="progress-bar"
                          role="progressbar"
                          style="width: 60%; background-color: var(--baby-pink)"
                        ></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <h5 class="mb-3">
              <i
                class="fas fa-utensils me-2"
                style="color: var(--baby-orange)"
              ></i
              >Today's Meals
            </h5>
            <div class="row">
              <div class="col-md-6">
                <div class="meal-card">
                  <div
                    class="d-flex justify-content-between align-items-center mb-2"
                  >
                    <h6 class="mb-0">
                      <i
                        class="fas fa-sun me-2"
                        style="color: var(--baby-orange)"
                      ></i
                      >Breakfast
                    </h6>
                    <small class="text-muted">8:30 AM</small>
                  </div>
                  <div class="d-flex flex-wrap mb-2">
                    <span
                      class="nutrition-badge"
                      style="
                        background-color: rgba(255, 179, 71, 0.1);
                        color: var(--baby-orange);
                      "
                    >
                      <i class="fas fa-bowl-food me-1"></i>Oatmeal (½ cup)
                    </span>
                    <span
                      class="nutrition-badge"
                      style="
                        background-color: rgba(152, 255, 152, 0.2);
                        color: var(--baby-green);
                      "
                    >
                      <i class="fas fa-apple-alt me-1"></i>Mashed banana
                    </span>
                  </div>
                  <div class="nutrition-fact">
                    <span>Approx. Nutrition:</span>
                    <span><strong>150 kcal</strong>, 3g protein</span>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="meal-card">
                  <div
                    class="d-flex justify-content-between align-items-center mb-2"
                  >
                    <h6 class="mb-0">
                      <i
                        class="fas fa-cloud-sun me-2"
                        style="color: var(--baby-blue)"
                      ></i
                      >Lunch
                    </h6>
                    <small class="text-muted">12:15 PM</small>
                  </div>
                  <div class="d-flex flex-wrap mb-2">
                    <span
                      class="nutrition-badge"
                      style="
                        background-color: rgba(137, 207, 240, 0.1);
                        color: var(--baby-blue);
                      "
                    >
                      <i class="fas fa-fish me-1"></i>Mashed salmon (30g)
                    </span>
                    <span
                      class="nutrition-badge"
                      style="
                        background-color: rgba(255, 182, 193, 0.1);
                        color: var(--baby-pink);
                      "
                    >
                      <i class="fas fa-carrot me-1"></i>Sweet potato puree
                    </span>
                  </div>
                  <div class="nutrition-fact">
                    <span>Approx. Nutrition:</span>
                    <span><strong>220 kcal</strong>, 8g protein</span>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="meal-card">
                  <div
                    class="d-flex justify-content-between align-items-center mb-2"
                  >
                    <h6 class="mb-0">
                      <i
                        class="fas fa-cloud me-2"
                        style="color: var(--baby-pink)"
                      ></i
                      >Snack
                    </h6>
                    <small class="text-muted">3:45 PM</small>
                  </div>
                  <div class="d-flex flex-wrap mb-2">
                    <span
                      class="nutrition-badge"
                      style="
                        background-color: rgba(230, 230, 250, 0.3);
                        color: var(--baby-lavender);
                      "
                    >
                      <i class="fas fa-cheese me-1"></i>Yogurt (¼ cup)
                    </span>
                    <span
                      class="nutrition-badge"
                      style="
                        background-color: rgba(255, 179, 71, 0.1);
                        color: var(--baby-orange);
                      "
                    >
                      <i class="fas fa-bread-slice me-1"></i>Toast fingers
                    </span>
                  </div>
                  <div class="nutrition-fact">
                    <span>Approx. Nutrition:</span>
                    <span><strong>120 kcal</strong>, 4g protein</span>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="meal-card">
                  <div
                    class="d-flex justify-content-between align-items-center mb-2"
                  >
                    <h6 class="mb-0">
                      <i
                        class="fas fa-moon me-2"
                        style="color: var(--baby-purple)"
                      ></i
                      >Dinner
                    </h6>
                    <small class="text-muted">Pending</small>
                  </div>
                  <button class="btn-nutrition w-100">
                    <i class="fas fa-plus me-1"></i> Add Dinner
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Feeding Schedule Tab -->
          <div class="tab-pane fade" id="schedule" role="tabpanel">
            <div class="row">
              <div class="col-md-6">
                <div class="intake-card">
                  <h5 class="mb-4">
                    <i
                      class="fas fa-baby me-2"
                      style="color: var(--baby-blue)"
                    ></i
                    >Recommended Feeding Schedule
                  </h5>

                  <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-connector"></div>
                    <div>
                      <h6>Morning (7-8 AM)</h6>
                      <p class="mb-1">Formula/Breast Milk (180-240ml)</p>
                      <small class="text-muted"
                        >Start the day with milk feeding</small
                      >
                    </div>
                  </div>

                  <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-connector"></div>
                    <div>
                      <h6>Breakfast (8:30-9 AM)</h6>
                      <p class="mb-1">Iron-fortified cereal + fruit</p>
                      <small class="text-muted"
                        >Example: ½ cup oatmeal + mashed banana</small
                      >
                    </div>
                  </div>

                  <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-connector"></div>
                    <div>
                      <h6>Mid-Morning (10:30 AM)</h6>
                      <p class="mb-1">Formula/Breast Milk (120-180ml)</p>
                      <small class="text-muted">Small milk feeding</small>
                    </div>
                  </div>

                  <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-connector"></div>
                    <div>
                      <h6>Lunch (12-1 PM)</h6>
                      <p class="mb-1">Protein + Vegetable + Grain</p>
                      <small class="text-muted"
                        >Example: Mashed salmon + sweet potato + rice</small
                      >
                    </div>
                  </div>

                  <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-connector"></div>
                    <div>
                      <h6>Afternoon (3-4 PM)</h6>
                      <p class="mb-1">Snack + Water</p>
                      <small class="text-muted"
                        >Example: Yogurt + toast fingers + 60ml water</small
                      >
                    </div>
                  </div>

                  <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-connector d-none"></div>
                    <div>
                      <h6>Dinner (6-7 PM)</h6>
                      <p class="mb-1">Protein + Vegetable</p>
                      <small class="text-muted"
                        >Example: Chicken puree + mashed carrots</small
                      >
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="intake-card h-100">
                  <h5 class="mb-4">
                    <i
                      class="fas fa-lightbulb me-2"
                      style="color: var(--baby-orange)"
                    ></i
                    >Nutrition Tips
                  </h5>
                  <div class="alert alert-light mb-3">
                    <i
                      class="fas fa-seedling me-2"
                      style="color: var(--baby-green)"
                    ></i>
                    <strong>Introduce new foods one at a time</strong> - Wait
                    3-5 days between new foods to check for allergies
                  </div>
                  <div class="alert alert-light mb-3">
                    <i
                      class="fas fa-tint me-2"
                      style="color: var(--baby-blue)"
                    ></i>
                    <strong>Offer water with meals</strong> - About 60-120ml per
                    day in a sippy cup
                  </div>
                  <div class="alert alert-light mb-3">
                    <i
                      class="fas fa-utensils me-2"
                      style="color: var(--baby-pink)"
                    ></i>
                    <strong>Encourage self-feeding</strong> - Offer soft finger
                    foods to develop motor skills
                  </div>
                  <div class="alert alert-light">
                    <i
                      class="fas fa-allergies me-2"
                      style="color: var(--baby-purple)"
                    ></i>
                    <strong>Watch for allergies</strong> - Common allergens
                    include eggs, peanuts, and dairy
                  </div>

                  <button class="btn-nutrition w-100 mt-4">
                    <i class="fas fa-calendar-plus me-1"></i> Customize Schedule
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Food Library Tab -->
          <div class="tab-pane fade" id="foods" role="tabpanel">
            <div class="row mb-4">
              <div class="col-md-6">
                <div class="input-group mb-3">
                  <span class="input-group-text"
                    ><i class="fas fa-search"></i
                  ></span>
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Search foods..."
                  />
                  <button class="btn btn-outline-secondary" type="button">
                    Search
                  </button>
                </div>
              </div>
              <div class="col-md-6">
                <div class="d-flex justify-content-end">
                  <div class="btn-group" role="group">
                    <button
                      type="button"
                      class="btn btn-outline-secondary active"
                    >
                      All
                    </button>
                    <button type="button" class="btn btn-outline-secondary">
                      Fruits
                    </button>
                    <button type="button" class="btn btn-outline-secondary">
                      Veggies
                    </button>
                    <button type="button" class="btn btn-outline-secondary">
                      Proteins
                    </button>
                    <button type="button" class="btn btn-outline-secondary">
                      Grains
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4 mb-4">
                <div class="meal-card h-100">
                  <div class="food-icon mx-auto mb-3">
                    <i class="fas fa-apple-alt"></i>
                  </div>
                  <h5 class="text-center">Apple</h5>
                  <div class="nutrition-fact">
                    <span>Prep:</span>
                    <span>Steamed & Mashed</span>
                  </div>
                  <div class="nutrition-fact">
                    <span>Age:</span>
                    <span>6+ months</span>
                  </div>
                  <div class="nutrition-fact">
                    <span>Nutrition (per 100g):</span>
                    <span>52 kcal, 0.3g protein</span>
                  </div>
                  <button class="btn-nutrition w-100 mt-3">
                    <i class="fas fa-plus me-1"></i> Add to Meal
                  </button>
                </div>
              </div>

              <div class="col-md-4 mb-4">
                <div class="meal-card h-100">
                  <div class="food-icon mx-auto mb-3">
                    <i class="fas fa-carrot"></i>
                  </div>
                  <h5 class="text-center">Carrot</h5>
                  <div class="nutrition-fact">
                    <span>Prep:</span>
                    <span>Steamed & Pureed</span>
                  </div>
                  <div class="nutrition-fact">
                    <span>Age:</span>
                    <span>6+ months</span>
                  </div>
                  <div class="nutrition-fact">
                    <span>Nutrition (per 100g):</span>
                    <span>41 kcal, 0.9g protein</span>
                  </div>
                  <button class="btn-nutrition w-100 mt-3">
                    <i class="fas fa-plus me-1"></i> Add to Meal
                  </button>
                </div>
              </div>

              <div class="col-md-4 mb-4">
                <div class="meal-card h-100">
                  <div class="food-icon mx-auto mb-3">
                    <i class="fas fa-drumstick-bite"></i>
                  </div>
                  <h5 class="text-center">Chicken</h5>
                  <div class="nutrition-fact">
                    <span>Prep:</span>
                    <span>Cooked & Shredded</span>
                  </div>
                  <div class="nutrition-fact">
                    <span>Age:</span>
                    <span>8+ months</span>
                  </div>
                  <div class="nutrition-fact">
                    <span>Nutrition (per 100g):</span>
                    <span>165 kcal, 31g protein</span>
                  </div>
                  <button class="btn-nutrition w-100 mt-3">
                    <i class="fas fa-plus me-1"></i> Add to Meal
                  </button>
                </div>
              </div>
            </div>

            <div class="text-center">
              <button class="btn-nutrition">
                <i class="fas fa-plus-circle me-1"></i> Add Custom Food
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
