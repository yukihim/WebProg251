<?php
$pageTitle = "Homepage - The Executive Garage";
include '../app/Views/partials/header.php';

require_once '../app/controllers/CarController.php';
require_once '../app/controllers/BrandController.php';

$carController = new CarController();
$brandController = new BrandController();

$carsPerPage = 6;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $carsPerPage;

$totalCars = 0;

$brands = $brandController->getAllBrands();

$keyword = $_GET['keyword'] ?? null;
$brand_id = $_GET['brand_id'] ?? null;

if (!empty($keyword)) {
    // To search cars with pagination from offset to limit with searching
    $cars = $carController->searchCarsPaginated($keyword, $carsPerPage, $offset);

    $totalCars = $carController->countSearchCars($keyword);
} elseif (!empty($brand_id)) {
    // To get cars by brand with pagination from offset to limit with brand filter
    $cars = $carController->showByBrandPaginated($brand_id, $carsPerPage, $offset);

    $totalCars = $carController->countCarsByBrand($brand_id);
} else {
    // To list cars with pagination from offset to limit
    $cars = $carController->listCarsPaginated($carsPerPage, $offset);

    $totalCars = $carController->countCars();
}

// Round up total pages: 13 jobs (13/12 = 1.08) -> 2 pages
$totalPages = ceil($totalCars / $carsPerPage);
?>

<section class="hero-section text-center py-5 bg-white shadow-sm rounded mb-4">
    <?php if (isset($_SESSION['message'])): ?>
        <h1 style="color: #0d6efd; font-weight: bold; margin-bottom: 20px;">
            <?= htmlspecialchars($_SESSION['message']) ?>
        </h1>
    <?php else: ?>
        <h1 class="fw-bold mb-3">Discover Your Dream Ride</h1>
    <?php endif; ?>
    <p class="text-muted mb-4">
        Explore an exclusive collection of luxury and performance automobiles. <br>
        Uncover the perfect match for your lifestyle, curated from the finest brands and locations.
    </p>
    <form class="d-flex justify-content-center" method="get" action="">
        <div class="position-relative w-50 me-2">
            <input type="text" 
                id="searchBox" 
                name="keyword" 
                value="<?= htmlspecialchars($keyword ?? '') ?>"
                class="form-control" 
                placeholder="Search by automobile's name">
            <div id="searchSuggestions" 
                class="list-group position-absolute w-100"
                style="z-index:1000; top:100%; left:0;"></div>
        </div>
        <button class="btn btn-primary" type="submit">
            <i class="fa-solid fa-magnifying-glass"></i> Search
        </button>
    </form>
</section>

<?php
    // Find brand name for breadcrumb
    $breadcrumbBrand = null;
    foreach ($brands as $brand) {
        if ($brand['bid'] == $brand_id) {
            $breadcrumbBrand = $brand['brand_name'];
            break;
        }
    }
?>
<section class="mt-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3" style="display: flex; flex-wrap: wrap; align-items: center; gap: 1em">
        <div>Navigation: </div>
        <ol class="breadcrumb mb-0" style="--bs-breadcrumb-divider: '>';">
            <li class="breadcrumb-item">
                <a href="index.php" class="ref">Homepage</a>
            </li>
            <?php if ($breadcrumbBrand): ?>
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="index.php?brand_id=<?= $brand_id ?>" class="ref">
                        <?= htmlspecialchars($breadcrumbBrand) ?>
                    </a>
                </li>
            <?php endif; ?>
        </ol>
    </nav>

    <?php if ($brand_id): ?>
        <!-- Button to redirect to index.php to show all brands -->
        <a href="index.php" class="btn btn-primary mb-4 gap-2">
            <i class="fa-solid fa-arrow-left"></i> Back to All Brands
        </a>
    <?php endif; ?>
</section>

<section class="my-5">
    <div class="row text-center">
        <?php foreach ($brands as $brand): ?>
            <?php
                $basePath = $_SERVER['DOCUMENT_ROOT'] . '/quanswebsite/public/uploads/';
                $brandFileName = urlencode($brand['brand_name']);
                $imgUrl = '';
                if (file_exists($basePath . $brandFileName . '.jpg')) {
                    $imgUrl = "/quanswebsite/public/uploads/{$brandFileName}.jpg";
                } elseif (file_exists($basePath . $brandFileName . '.png')) {
                    $imgUrl = "/quanswebsite/public/uploads/{$brandFileName}.png";
                } else {
                    $imgUrl = "/quanswebsite/public/uploads/default.jpg"; // fallback image
                }
            ?>
            <div class="col-md-3 col-6 mb-3">
                <a href="index.php?brand_id=<?= $brand['bid'] ?>"
                    class="brand-btn w-100"
                    style="background-image: url('<?= $imgUrl ?>'); height: 15em; background-size: cover; background-position: center; color: #fff;">
                    <span class="brand-name"
                        style="width: 100%; height: 100%; justify-content: center; align-items: center; display: flex;">
                        <?= htmlspecialchars($brand['brand_name']) ?>
                    </span>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="my-5">
    <!-- <h2 class="text-center mb-4">
        <i class="fa-solid fa-car"></i>
        <?php
        if ($keyword) echo "Search results for “" . htmlspecialchars($keyword) . "”";
        elseif ($brand_id) echo "Cars from selected brand";
        else echo "Available Cars";
        ?>
    </h2> -->

    <?php if (empty($cars)): ?>
        <p class="text-center text-muted">No cars found.</p>
    <?php else: ?>
        <div class="row">
            <?php foreach ($cars as $car): ?>
                <div class="col-md-4 mb-4">
                    <a href="../app/Views/car/show.php?cid=<?= $car['cid'] ?>" class="text-decoration-none text-reset">
                        <div class="card h-100 d-flex flex-column">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($car['model_name']) ?></h5>
                                <p class="text-muted mb-1">
                                    <i class="fa-regular fa-dollar-sign"></i> <?= htmlspecialchars($car['price']) ?>
                                </p>
                                <p class="text-muted">
                                    <i class="fa-solid fa-calendar"></i> <?= htmlspecialchars($car['year']) ?>
                                </p>
                                <p class="small"><?= htmlspecialchars(substr($car['description'], 0, 100)) ?>...</p>
                            </div>
                            <!-- car image-->
                            <?php
                                $carImageUrl = $car['image_url'];

                                $imgUrl = '';
                                if (file_exists("../app/Views/images/{$carImageUrl}")) {
                                    $imgUrl = "../app/Views/images/{$carImageUrl}";
                                } else {
                                    $imgUrl = "/uploads/default_car.jpg"; // fallback image
                                }
                            ?>
                            <div class="mx-2 mb-2"
                                style="flex-grow: 1; display: flex; align-items: flex-end; border-radius: 0.5em; overflow: hidden;">
                                <img src="<?= $imgUrl ?>" 
                                    alt="<?= htmlspecialchars($car['model_name']) ?>"
                                    class="img-fluid w-100"
                                    style="max-height: 200px; object-fit: cover; border-radius: 0.5em;">
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <nav aria-label="Car pagination">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link"
                    href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>">
                    <?= $i ?>
                    </a>
                </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>
</section>

<?php include '../app/Views/partials/footer.php'; ?>