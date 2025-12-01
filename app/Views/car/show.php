<?php
$pageTitle = "Car Details";
include '../partials/header.php';

require_once '../../controllers/CarController.php';
require_once '../../controllers/BrandController.php';
require_once '../../controllers/LocationController.php';
require_once '../../controllers/BodyStyleController.php';

$carController = new CarController();
$brandController = new BrandController();
$locationController = new LocationController();
$bodyStyleController = new BodyStyleController();

if (!isset($_GET['cid'])) {
    echo "<div class='alert alert-danger text-center mt-5'>No car selected.</div>";
    include '../partials/footer.php';
    exit;
}

$cid = intval($_GET['cid']);
$car = $carController->showCar($cid);
$carInventory = $carController->getCarInventory($car['cid']);

$brandName = $brandController->getBrandNameById($car['brand_id']);
$bodyStyle = $bodyStyleController->getBodyStyleById($car['style_id']);

if (!$car) {
    echo "<div class='alert alert-warning text-center mt-5'>Car not found or unavailable.</div>";
    include '../partials/footer.php';
    exit;
}
?>

<nav aria-label="breadcrumb"
    class="container px-3"
    style="display: flex; flex-wrap: wrap; align-items: center;">
    <div style="margin-right: 0.5em;">Navigation:</div>
    <ol class="breadcrumb" style="--bs-breadcrumb-divider: '>'; display: flex; flex-wrap: wrap; align-items: center; margin-bottom: 0;">
        <li class="breadcrumb-item">
            <a href="../../../public/index.php" class="ref"">
                Home
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="../../../public/index.php?brand_id=<?php echo $car['brand_id'] ?>" class="ref">
                <?php echo htmlspecialchars($brandName['brand_name']) ?>
            </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            <a href="../../../app/Views/car/show.php?cid=<?php echo $car['cid'] ?>" class="ref">
                <?php echo htmlspecialchars($car['model_name']) ?>
            </a>
        </li>
    </ol>
</nav>

<div class="container mt-3 mb-5">
    <div class="card shadow-sm p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="fw-bold mb-0">
                <?php echo htmlspecialchars($car['model_name']) ?>
            </h2>
        </div>

        <div class="d-flex flex-column gap-2 mt-2">
            <div class="d-flex align-items-center text-muted mb-1">
                <i class="fa fa-car me-2 fa-fw"></i>
                <span>
                    Body style: <?php echo htmlspecialchars($bodyStyle['style_name']) ?>
                </span>
            </div>
            <div class="d-flex align-items-center text-muted mb-1">
                <i class="fa-regular fa-dollar-sign me-2 fa-fw"></i>
                <span>
                    Price: <?php echo number_format($car['price'], 0, '', '.') ?>
                </span>
            </div>
            <div class="d-flex align-items-center text-muted mb-1">
                <i class="fa-solid fa-calendar me-2 fa-fw"></i>
                <span>
                    Year: <?php echo htmlspecialchars($car['year']) ?>
                </span>
            </div>
            <div class="d-flex align-items-center text-muted mb-0">
                <i class="fa-solid fa-location-dot fa-fw me-2"></i> Available at:
            </div>
            <div class="ms-4 mb-2">
                <?php if (!empty($carInventory)): ?>
                    <ul class="mb-0 ps-3">
                        <?php foreach ($carInventory as $location): ?>
                            <li>
                                <a class="location-link"
                                    title="<?php echo htmlspecialchars($location['address']) ?>"
                                    href="<?php echo htmlspecialchars($location['Maps_url']) ?>"
                                    target="_blank"
                                    rel="noopener">
                                    <?php echo htmlspecialchars($location['location_name']) ?>
                                </a>
                                (<?php echo htmlspecialchars($location['amount']) ?> available)
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <span>Location not available</span>
                <?php endif; ?>
            </div>
        </div>

        <h5 class="mt-4">Car Details</h5>
        <p><?php echo nl2br(htmlspecialchars($car['description'])) ?></p>

        <!-- car image-->
        <?php
            $carImageUrl = $car['image_url'];
            $imgUrl = '';
            if (file_exists("../images/{$carImageUrl}")) {
                $imgUrl = "../images/{$carImageUrl}";
            } else {
                $imgUrl = "../../../public/uploads/default.jpg"; // fallback image
            }
        ?>
        <div class="mx-2 mb-2"
            style="flex-grow: 1; display: flex; align-items: flex-end; border-radius: 0.5em; overflow: hidden;">
            <img src="<?php echo $imgUrl ?>"
                alt="<?php echo htmlspecialchars($car['model_name']) ?>"
                class="img-fluid w-100"
                style="max-height: 40em; object-fit: cover;">
        </div>

        <hr>

        <div class="d-flex justify-content-between align-items-center">
            <a href="../../../public/index.php" class="btn btn-outline-secondary gap-2">
                <i class="fa-solid fa-arrow-left"></i> Back to Homepage
            </a>
        </div>
    </div>
</div>

<?php include '../partials/footer.php'; ?>
