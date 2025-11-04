<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<section class="hero d-flex align-items-center text-center">
  <div class="container">
    <h1 class="fw-bold">Welcome to InsightHub</h1>
    <p class="lead mt-3">Your go-to platform for blogs, guides, and resources to grow your knowledge and career.</p>
    <a href="resources.php" class="btn btn-primary mt-3">Explore Resources</a>
  </div>
</section>

<!---about us section -->
<section class="py-5 bg-light">
  <div class="container text-center">
    <h2 class="fw-bold mb-4">About InsightHub</h2>
    <p class="text-muted mx-auto" style="max-width: 700px;">
      InsightHub is a platform created to empower young developers, students, and professionals with
      practical knowledge and reliable resources. Our mission is to make learning accessible, engaging, 
      and impactful — one article, one guide, and one resource at a time.
    </p>
  </div>
</section>

<section class="py-5">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6 mb-4 mb-md-0">
        <img src="assets/images/about.jpg" alt="About InsightHub" class="img-fluid rounded shadow-sm">
      </div>
      <div class="col-md-6">
        <h3 class="fw-bold mb-3">Our Vision</h3>
        <p>To become a leading global resource hub for tech enthusiasts, entrepreneurs, and creatives.</p>
        <h3 class="fw-bold mb-3 mt-4">Our Mission</h3>
        <p>We aim to bridge the knowledge gap by providing free educational content, mentorship,
           and insights that spark innovation and growth.</p>
      </div>
    </div>
  </div>
</section>

<!-- Featured Blog Section -->
<section class="py-5">
  <div class="container">
    <h2 class="text-center mb-4 fw-bold">Featured Articles</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <img src="assets/images/blog1.jpg" class="card-img-top" alt="Blog 1">
          <div class="card-body">
            <h5 class="card-title">5 Productivity Hacks for Developers</h5>
            <p class="card-text">Discover practical ways to boost your efficiency and focus as a software developer.</p>
            <a href="#" class="btn btn-outline-primary btn-sm">Read More</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <img src="assets/images/blog2.jpg" class="card-img-top" alt="Blog 2">
          <div class="card-body">
            <h5 class="card-title">How to Start a Tech Blog</h5>
            <p class="card-text">Learn the steps and tools needed to share your knowledge and build your personal brand.</p>
            <a href="#" class="btn btn-outline-primary btn-sm">Read More</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <img src="assets/images/blog3.jpg" class="card-img-top" alt="Blog 3">
          <div class="card-body">
            <h5 class="card-title">Top 10 Free Developer Resources</h5>
            <p class="card-text">Explore a curated list of free tools, APIs, and tutorials for every aspiring developer.</p>
            <a href="#" class="btn btn-outline-primary btn-sm">Read More</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
