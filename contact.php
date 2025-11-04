<?php include 'includes/header.php'; ?>

<section class="py-5">
  <div class="container">
    <h2 class="text-center fw-bold mb-4">Contact Us</h2>
    <p class="text-center text-muted mb-5">We’d love to hear from you! Fill out the form below and we’ll get back to you soon.</p>

    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card shadow-sm">
          <div class="card-body">
            <form method="post" action="includes/send_message.php">
              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="name" class="form-label">Full Name</label>
                  <input type="text" id="name" name="name" class="form-control" required>
                </div>
                <div class="col-md-6">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" id="email" name="email" class="form-control" required>
                </div>
              </div>

              <div class="mb-3">
                <label for="subject" class="form-label">Subject</label>
                <input type="text" id="subject" name="subject" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea id="message" name="message" class="form-control" rows="5" required></textarea>
              </div>

              <div class="text-end">
                <button type="submit" class="btn btn-primary">Send Message</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
