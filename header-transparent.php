<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>OE Sub</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.0/css/font-awesome.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="<?php echo get_theme_file_uri() . '/assets/css/style-header.css'; ?>" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
  <?php wp_head(); ?>

</head>

<body style="background-color: rgb(255, 255, 255)" <?php body_class(); ?>>
  <header class="navbar-default navbar-fixed-top ar-header" role="banner">
    <div class="container-fluid ar-flex">
      <div class="ar-child-flex1">
        <div class="logo-box">
          <a class="navbar-brand" href="<?php site_url(); ?>"><img src="<?php echo get_theme_file_uri() . '/assets/img/logo.png'; ?>" /></a>
        </div>

        <form class="form-inline">
          <input class="ar-search-form" type="text" placeholder="Search for your courses..." />
        </form>
      </div>

      <div class="ar-child-flex2">
        <nav class="navbar-collapse collapse" role="navigation">
          <ul class="nav navbar-nav">

            <li class="dropdown">
              <a data-toggle="dropdown" class="dropdown-toggle ar-icon" href="#">Courses</a>
              <ul class="dropdown-menu ar-drp-menu">
                <li><a href="#">Courses</a></li>
                <li>
                  <a href="#">Key Features</a>
                  <ul class="child-drop">
                    <li><a href="#">Course Content</a></li>
                    <li><a href="#">Training Delivery</a></li>
                    <li><a href="#">Security & Reliability</a></li>
                    <li><a href="#">Personal Service & Support</a></li>
                    <li><a href="#">After Sales Care</a></li>
                  </ul>
                </li>

                <li><a href="#">LMS</a></li>
                <li><a href="#">Something else here</a></li>
                <li><a href="#">Management & Reporting</a></li>
                <li><a href="#">Pay as you go</a></li>
              </ul>
            </li>

            <li class="dropdown">
              <a class="dropdown-toggle ar-icon" href="#">Features</a>

              <div class="dropdown-menu">
                <div class="ar-drp-menu2">
                  <div class="ar-list">
                    <ul class="ar-firstul">
                      <li>
                        <a href="#">Resources</a>
                        <ul class="child-drop2">
                          <li><a href="#">Podcasts</a></li>
                          <li><a href="#">Case Studies</a></li>
                          <li><a href="#">Blogs</a></li>
                        </ul>
                      </li>
                    </ul>
                  </div>

                  <div class="ar-slider">
                    <div class="ar-slider-top">
                      <h4 class="ar-feature">Feature</h4>
                      <div class="ar-prev-next">
                        <i class="fa fa-long-arrow-left ar-slide-prev" aria-hidden="true"></i>
                        <i class="fa fa-long-arrow-right ar-slide-next" aria-hidden="true"></i>
                      </div>
                    </div>
                    <div class="ar-sliders">
                      <div class="ar-slides active">
                        <figure class="ar-items">
                          <div class="ar-image"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/331810/pr-sample23.jpg" alt="pr-sample23" /></div>
                          <figcaption>
                            <h3>The World Ended Yesterday</h3>
                            <div class="ar-date"> <img src="<?php echo get_theme_file_uri() . 'assets/img/fontisto_date.png'; ?>" alt=""> Mon, Sep 24 - Oct 16</div>
                          </figcaption>
                          <a href="#"></a>
                        </figure>
                      </div>
                      <div class="ar-slides">
                        <figure class="ar-items">
                          <div class="ar-image"><img src="<?php echo get_theme_file_uri() . 'assets/img/Rectangle 3088.png'; ?>" alt="pr-sample23" /></div>
                          <figcaption>
                            <h3>This is Slider Number 2</h3>
                            <div class="ar-date">Mon, Sep 25 - Oct 16</div>
                          </figcaption>
                          <a href="#"></a>
                        </figure>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </li>

            <li><a href="#contact">Pricing</a></li>

            <li class="dropdown"><a class="dropdown-toggle ar-icon" href="#">Features</a>
              <div class="dropdown-menu ar-drp-menu3" style="display: none;">

                <ul class="ar-ullist">
                  <li> <img src="<?php echo get_theme_file_uri() . '/assets/img/emojione-monotone_pot-of-food.png'; ?>"> Food Hygiene </li>
                  <li class="ar-activeMenu"> <img src="<?php echo get_theme_file_uri() . '/assets/img/healthicons_health.png'; ?>"> Health & Safety </li>
                  <li> <img src="<?php echo get_theme_file_uri() . '/assets/img/bxs_first-aid.png'; ?>"> First Aid </li>
                  <li> <img src="<?php echo get_theme_file_uri() . '/assets/img/team-leader 1.png'; ?>"> Business Compliance </li>
                  <li> <img src="<?php echo get_theme_file_uri() . '/assets/img/fa-solid_graduation-cap.png'; ?>"> Education </li>
                  <li> <img src="<?php echo get_theme_file_uri() . '/assets/img/healthicons_wold-care-negative.png'; ?>"> Social Care </li>
                  <li> <img src="<?php echo get_theme_file_uri() . '/assets/img/icon-park-solid_protect.png'; ?>"> Cyber Security </li>
                  <li> <img src="<?php echo get_theme_file_uri() . '/assets/img/hr 1.png'; ?>"> HR </li>
                </ul>

                <a href="#" class="ar-btnlg">
                  <img src="<?php echo get_theme_file_uri() . 'assets/img/healthicons_ui-menu-grid.png'; ?>">Access to Our Course Library
                </a>
              </div>
            </li>

          </ul>
        </nav>

        <a class="ar-cart-icon" href="#"><img src="<?php echo get_theme_file_uri() . '/assets/img/Frame 8.png'; ?>" /></a>
        <a class="ar-btn1"><img src="<?php echo get_theme_file_uri() . '/assets/img/clarity_user-solid.png'; ?>" />My Account</a>
      </div>
    </div>
  </header>

  <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <script>
    function Slider() {
      let back = document.querySelector('.ar-slide-prev')
      let go = document.querySelector('.ar-slide-next')
      let items = document.querySelectorAll('.ar-slides')
      let i = 0;
      go.addEventListener('click', () => {
        i++
        if (items.length - 1 < i) {
          i = 0
        }
        items.forEach(item => {
          item.classList.remove('active')
        })
        items[i].classList.add('active')
      })

      back.addEventListener('click', () => {
        i--;
        if (0 >= i) {
          i = 0
        }
        items.forEach(item => {
          item.classList.remove('active')
        })
        items[i].classList.add('active')
        console.log(i)
      })
    }
    Slider();

    // Dropdown Menu Fade
    jQuery(document).ready(function() {
      jQuery(".dropdown").hover(
        function() {
          jQuery(".dropdown-menu", this).fadeIn("fast");
        },
        function() {
          jQuery(".dropdown-menu", this).fadeOut("fast");
        }
      );
    });

    // Menu Hover
    var selector = '.ar-ullist li';
    jQuery(selector).hover(function() {
      jQuery(selector).removeClass('ar-activeMenu');
      jQuery(this).addClass('ar-activeMenu');
    });
  </script>

</body>

</html>