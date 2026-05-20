<?php
/*
*/

// IMPORTANT: Put the email address where you want to receive CVs below.
$recipientEmail = " casandra.banu@ask33.co.uk"; 

if (!function_exists('get_template_directory_uri')) {
    function get_template_directory_uri() { return '.'; }
}
if (!function_exists('home_url')) {
    function home_url($path = '') { return '/' . ltrim($path, '/'); }
}

// SEO VARIABLES
$page_title = "Student Advisor (Remote) - Join the Team | One Guide";
$page_desc = "Join One Guide as a Student Advisor. 100% Remote, Flexible Schedule, High Earnings (up to £1,200/student). No experience required, full training provided. Apply now.";
$page_url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$page_image = get_template_directory_uri() . "/images/One-Guide.png"; // Fallback image
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title><?php echo $page_title; ?></title>
    <meta name="description" content="<?php echo $page_desc; ?>">
    <meta name="keywords" content="Student Advisor, Remote Job, Work from Home, Education Consultant, UK University Admissions, Ask33 Recruitment, One Guide">
    <meta name="author" content="One Guide Advisors">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?php echo $page_url; ?>">

    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $page_url; ?>">
    <meta property="og:title" content="We are Hiring: Student Advisor (100% Remote)">
    <meta property="og:description" content="Flexible work, high earnings up to £1,200 per student. Help students study in the UK. Apply today!">
    <meta property="og:image" content="<?php echo $page_image; ?>">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo $page_url; ?>">
    <meta property="twitter:title" content="We are Hiring: Student Advisor (Remote)">
    <meta property="twitter:description" content="Flexible work, high earnings. Join our team today.">
    <meta property="twitter:image" content="<?php echo $page_image; ?>">

    <script type="application/ld+json">
    {
      "@context": "https://schema.org/",
      "@type": "JobPosting",
      "title": "Student Advisor",
      "description": "<p>We are looking for involved, persistent, and motivated people who want to work as a Student Advisor. This collaboration is 100% remote and ideal if you want to work from home with a flexible schedule.</p><p><strong>Benefits:</strong></p><ul><li>High Earnings: Up to £1,200 per student</li><li>100% Remote: Work from anywhere</li><li>Flexible: No fixed hours, no stress</li><li>Growth opportunities</li></ul><p><strong>Responsibilities:</strong></p><ul><li>Posting on social media</li><li>Communicating with interested students</li><li>Guiding applicants through registration</li></ul>",
      "identifier": {
        "@type": "PropertyValue",
        "name": "One Guide",
        "value": "OG-001"
      },
      "datePosted": "<?php echo date('Y-m-d'); ?>",
      "validThrough": "<?php echo date('Y-m-d', strtotime('+6 months')); ?>",
      "employmentType": "CONTRACTOR",
      "hiringOrganization": {
        "@type": "Organization",
        "name": "One Guide / Ask33",
        "sameAs": "<?php echo home_url(); ?>",
        "logo": "<?php echo get_template_directory_uri(); ?>/images/One-Guide.png"
      },
      "jobLocationType": "TELECOMMUTE",
      "applicantLocationRequirements": {
        "@type": "Country",
        "name": "UK"
      },
      "baseSalary": {
        "@type": "MonetaryAmount",
        "currency": "GBP",
        "value": {
          "@type": "QuantitativeValue",
          "value": 1200,
          "unitText": "COMMISSION"
        }
      }
    }
    </script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Lora:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; background: transparent; color: #1e293b; overflow-x: hidden; position: relative; }
        h1, h2, h3 { font-family: 'Lora', serif; }
        
        #bg-fixed {
            position: fixed; 
            top: 0; 
            left: 0; 
            width: 100%; 
            height: 100%; 
            z-index: -2;
            background-image: linear-gradient(rgba(255,255,255,0.95), rgba(255,255,255,0.9)), url('<?php echo get_template_directory_uri(); ?>/images/background.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .glass-effect { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.3); }
        .fade-in { animation: fadeIn 0.8s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        
        .brand-text { font-family: 'Lora', serif; font-weight: 700; color: #1e3a8a; font-size: 1.1rem; }

        .nav-link { color: #475569; font-weight: 600; transition: 0.3s; }
        .nav-link:hover { color: #2563eb; }
        .nav-btn { background: #2563eb; color: white; padding: 10px 20px; border-radius: 8px; font-weight: bold; transition: 0.3s; }
        .nav-btn:hover { background: #1d4ed8; }

        .input-standard { background: #f9fafb; border: 1px solid #d1d5db; color: #1f2937; border-radius: 0.5rem; padding: 0.75rem; width: 100%; transition: all 0.2s; }
        .input-standard:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); outline: none; background: #ffffff; }

        .footer-socials { gap: 1rem; } 
        .footer-socials a { display: inline-flex; align-items: center; justify-content: center; width: 45px; height: 45px; border-radius: 50%; background: #f1f5f9; transition: 0.3s; font-size: 1.5rem; }
        .footer-socials a:hover { transform: translateY(-3px); }
        .icon-fb { color: #1877F2; } .icon-fb:hover { background: #1877F2; color: white; }
        .icon-li { color: #0A66C2; } .icon-li:hover { background: #0A66C2; color: white; }
        .icon-wa { color: #25D366; } .icon-wa:hover { background: #25D366; color: white; }
        .icon-tt { color: #000000; } .icon-tt:hover { background: #000000; color: white; }
        .icon-mail { color: #64748b; } .icon-mail:hover { background: #64748b; color: white; }

        #mobile-menu { display: none; position: absolute; top: 96px; left: 0; width: 100%; background: white; border-bottom: 2px solid #e2e8f0; padding: 20px; flex-direction: column; gap: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.1); z-index: 49; }
        #mobile-menu.active { display: flex; }
        .mobile-link { color: #334155; font-weight: 600; font-size: 1.1rem; text-align: center; padding: 10px; border-bottom: 1px solid #f1f5f9; }

        @media(max-width: 900px) {
            .mobile-toggle { display: block; }
            .desktop-menu { display: none; }
            h1 { font-size: 2.5rem; }
        }
    </style>
</head>
<body class="antialiased flex flex-col min-h-screen">

    <div id="bg-fixed"></div>

    <nav class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-28 flex justify-between items-center relative">
            
            <a href="index.php" class="flex flex-col items-center justify-center gap-0 group no-underline">
                <img src="<?php echo get_template_directory_uri(); ?>/images/One-Guide.png" alt="Logo" class="h-10 w-auto object-contain mb-1 transition group-hover:scale-105">
                
                <span class="brand-text text-sm font-bold text-blue-900 leading-tight">One Guide</span>
                <span class="text-sm font-medium text-gray-700">
        We help you find the right direction
    </span>

                <span class="text-[9px] font-bold text-blue-900 tracking-wide uppercase mt-0.5">
                    Powered by <span class="hover:text-red-600 active:text-red-700 transition-colors cursor-pointer" 
onclick="window.open('https://www.ask33.co.uk/', '_blank')">ASK 33</span>
                </span>
            </a>


            <div class="hidden md:flex gap-8 items-center desktop-menu">
                <a href="<?php echo home_url(); ?>#course-search" class="nav-link" data-key="nav_courses">Courses</a>
                <a href="<?php echo home_url(); ?>#team" class="nav-link" data-key="nav_team">Advisors</a>
                <a href="<?php echo home_url(); ?>#reviews" class="nav-link" data-key="nav_reviews">Reviews</a>
                
                <select onchange="changeLanguage(this.value)" class="input-standard py-2 pl-3 pr-8 text-sm bg-white border-gray-200 cursor-pointer w-auto">
                    <option value="en">🇬🇧 English</option>
                    <option value="ro">🇷🇴 Română</option>
                    <option value="pl">🇵🇱 Polski</option>
                    <option value="hu">🇭🇺 Magyar</option>
                    <option value="es">🇪🇸 Español</option>
                    <option value="it">🇮🇹 Italiano</option>
                    <option value="pt">🇵🇹 Português</option>
                    <option value="el">🇬🇷 Ελληνικά</option>
                    <option value="bg">🇧🇬 Български</option>
                </select>

                <a href="#apply" class="nav-btn shadow-lg" data-key="btn_apply_nav">Apply Now</a>
            </div>

            <button class="md:hidden p-2 text-slate-600 border border-slate-300 rounded-lg hover:bg-slate-100 transition mobile-toggle" onclick="toggleMobileMenu()">
                <i data-feather="menu"></i>
            </button>
        </div>

        <div id="mobile-menu">
            <a href="<?php echo home_url(); ?>#course-search" class="mobile-link" data-key="nav_courses">Courses</a>
            <a href="<?php echo home_url(); ?>#team" class="mobile-link" data-key="nav_team">Advisors</a>
            <a href="<?php echo home_url(); ?>#reviews" class="mobile-link" data-key="nav_reviews">Reviews</a>
            <a href="#apply" class="mobile-link text-blue-600 font-bold" onclick="toggleMobileMenu()" data-key="btn_apply_nav">Apply Now</a>
            
            <div class="mt-4 px-4 border-t border-slate-100 pt-4">
                <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Select Language</label>
                <select onchange="changeLanguage(this.value); toggleMobileMenu();" class="w-full p-3 border border-slate-300 rounded-lg bg-slate-50 text-slate-700 font-medium">
                    <option value="en">🇬🇧 English</option>
                    <option value="ro">🇷🇴 Română</option>
                    <option value="pl">🇵🇱 Polski</option>
                    <option value="hu">🇭🇺 Magyar</option>
                    <option value="es">🇪🇸 Español</option>
                    <option value="it">🇮🇹 Italiano</option>
                    <option value="pt">🇵🇹 Português</option>
                    <option value="el">🇬🇷 Ελληνικά</option>
                    <option value="bg">🇧🇬 Български</option>
                </select>
            </div>
        </div>
    </nav>

    <main class="flex-grow pt-32 pb-20 px-6">
        <div class="max-w-6xl mx-auto">
            
            <div class="text-center mb-16 fade-in">
                <span class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">Recruitment</span>
                <h1 class="text-4xl md:text-5xl font-bold text-slate-900 mt-4 mb-4" data-key="page_title">Join Ask33 Team</h1>
                <p class="text-xl text-blue-600 font-semibold" data-key="page_sub">Student Advisor (100% Remote)</p>
            </div>

            <div class="grid lg:grid-cols-12 gap-12 fade-in">
                
                <div class="lg:col-span-7 space-y-10">
                    
                    <div class="glass-effect bg-white p-8 rounded-2xl shadow-sm border border-slate-200">
                        <div class="flex items-center gap-4 mb-6">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/CasandraBanu.jpg" class="w-16 h-16 rounded-full border-2 border-blue-100 object-cover">
                            <div>
                                <h2 class="text-xl font-bold text-slate-900" data-key="role_title">Role Overview</h2>
                                <p class="text-sm text-slate-500">From Casandra Banu, Team Leader</p>
                            </div>
                        </div>
                        <p class="text-slate-600 leading-relaxed mb-6" data-key="role_desc">
                            In my role as Team Leader at Ask33, I am expanding my team and looking for involved, persistent, and motivated people who want to work as a Student Advisor, 100% remote. This collaboration is ideal if you want to work from home, have a flexible schedule, and help people build a better future through education.
                        </p>
                        
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div class="bg-green-50 p-4 rounded-xl border border-green-100">
                                <div class="flex items-center gap-2 mb-1">
                                    <i data-feather="dollar-sign" class="text-green-600 w-5 h-5"></i>
                                    <strong class="text-slate-900" data-key="ben_1">High Earnings</strong>
                                </div>
                                <p class="text-sm text-slate-600" data-key="ben_1_d">Up to £1,200 per student.</p>
                            </div>
                            <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                                <div class="flex items-center gap-2 mb-1">
                                    <i data-feather="home" class="text-blue-600 w-5 h-5"></i>
                                    <strong class="text-slate-900" data-key="ben_2">100% Remote</strong>
                                </div>
                                <p class="text-sm text-slate-600" data-key="ben_2_d">Work from anywhere.</p>
                            </div>
                            <div class="bg-purple-50 p-4 rounded-xl border border-purple-100">
                                <div class="flex items-center gap-2 mb-1">
                                    <i data-feather="clock" class="text-purple-600 w-5 h-5"></i>
                                    <strong class="text-slate-900" data-key="ben_3">Flexible</strong>
                                </div>
                                <p class="text-sm text-slate-600" data-key="ben_3_d">No fixed hours, no stress.</p>
                            </div>
                            <div class="bg-orange-50 p-4 rounded-xl border border-orange-100">
                                <div class="flex items-center gap-2 mb-1">
                                    <i data-feather="trending-up" class="text-orange-600 w-5 h-5"></i>
                                    <strong class="text-slate-900" data-key="ben_4">Growth</strong>
                                </div>
                                <p class="text-sm text-slate-600" data-key="ben_4_d">Real possibility of growth.</p>
                            </div>
                        </div>
                    </div>

                    <div class="glass-effect bg-slate-50 p-8 rounded-2xl border border-slate-200">
                        <div class="mb-8">
                            <h3 class="font-bold text-lg mb-4 text-slate-900" data-key="resp_title">What the Role Involves:</h3>
                            <ul class="space-y-3 text-slate-700">
                                <li class="flex items-start gap-3"><i data-feather="check" class="text-blue-500 w-5 h-5 mt-0.5"></i> <span data-key="resp_1">Constant posting on social media.</span></li>
                                <li class="flex items-start gap-3"><i data-feather="check" class="text-blue-500 w-5 h-5 mt-0.5"></i> <span data-key="resp_2">Communicating with people interested in university.</span></li>
                                <li class="flex items-start gap-3"><i data-feather="check" class="text-blue-500 w-5 h-5 mt-0.5"></i> <span data-key="resp_3">Guiding applicants through the registration process.</span></li>
                                <li class="flex items-start gap-3"><i data-feather="check" class="text-blue-500 w-5 h-5 mt-0.5"></i> <span data-key="resp_4">Maintaining contact with students during application.</span></li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="font-bold text-lg mb-4 text-slate-900" data-key="offer_title">What I Offer You:</h3>
                            <p class="text-sm text-slate-500 mb-4 italic" data-key="no_exp">No experience? No problem. Full training provided.</p>
                            <ul class="space-y-3 text-slate-700">
                                <li class="flex items-start gap-3"><i data-feather="star" class="text-yellow-500 w-5 h-5 mt-0.5"></i> <span data-key="off_1">Clear, structured training.</span></li>
                                <li class="flex items-start gap-3"><i data-feather="star" class="text-yellow-500 w-5 h-5 mt-0.5"></i> <span data-key="off_2">Continuous support and feedback.</span></li>
                                <li class="flex items-start gap-3"><i data-feather="star" class="text-yellow-500 w-5 h-5 mt-0.5"></i> <span data-key="off_3">Work strategies that actually work.</span></li>
                                <li class="flex items-start gap-3"><i data-feather="star" class="text-yellow-500 w-5 h-5 mt-0.5"></i> <span data-key="off_4">Friendly environment and united team.</span></li>
                            </ul>
                        </div>
                    </div>
                </div>

        <div class="lg:col-span-5" id="apply">
    <div class="glass-effect bg-white p-8 rounded-2xl shadow-xl border-t-4 border-blue-600 sticky top-28 relative overflow-hidden" style="min-height: 600px;">
        
        <div id="application-form-wrapper" class="transition-all duration-500 ease-in-out">
            <h2 class="text-2xl font-bold mb-2 text-slate-900" data-key="form_title">Apply Now</h2>
            <p class="text-sm text-slate-500 mb-6" data-key="form_sub">Send me a message with your details. Limited spots available.</p>
            
            <form id="join-team-form" action="https://formsubmit.co/ajax/<?php echo $recipientEmail; ?>" method="POST" enctype="multipart/form-data">
                
                <input type="hidden" name="_subject" value="New Job Application - One Guide">
                <input type="hidden" name="_captcha" value="false">
                <input type="hidden" name="_template" value="table">
                <input type="text" name="_honey" style="display:none">

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1" data-key="lbl_name">Full Name</label>
                        <input type="text" name="name" class="input-standard" required>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1" data-key="lbl_phone">Phone</label>
                        <input type="tel" name="phone" class="input-standard" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1" data-key="lbl_email">Email</label>
                        <input type="email" name="email" class="input-standard" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1" data-key="lbl_link">Social / LinkedIn</label>
                        <input type="text" name="social_link" class="input-standard">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1" data-key="lbl_cv">Upload CV / Resume</label>
                        <label class="flex flex-col items-center justify-center w-full h-24 border-2 border-slate-300 border-dashed rounded-lg cursor-pointer bg-slate-50 hover:bg-slate-100 hover:border-blue-400 transition">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i data-feather="upload-cloud" class="text-slate-400 mb-2"></i>
                                <p class="text-xs text-slate-500"><span class="font-bold" data-key="btn_upload">Click to upload</span> (PDF/DOCX)</p>
                            </div>
                            <input type="file" name="attachment" class="hidden" accept=".pdf,.docx,.doc" onchange="document.getElementById('file-chosen').textContent = this.files[0].name">
                        </label>
                        <p id="file-chosen" class="text-xs text-blue-600 mt-2 font-semibold text-center"></p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1" data-key="lbl_why">Why do you want to join?</label>
                        <textarea name="message" rows="3" class="input-standard" required></textarea>
                    </div>
                    
                    <button type="submit" id="submit-btn" class="w-full bg-blue-600 text-white py-4 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg flex justify-center items-center gap-2 group">
                        <span id="btn-text" data-key="btn_apply">Submit Application</span> 
                        <i id="btn-icon" data-feather="send" class="w-4 h-4 group-hover:translate-x-1 transition"></i>
                        <svg id="btn-spinner" class="animate-spin h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <div id="success-message" class="absolute inset-0 flex flex-col justify-center items-center text-center opacity-0 pointer-events-none transform translate-y-10 transition-all duration-700 ease-out bg-white z-10">
            <div class="bg-green-100 p-6 rounded-full mb-6 shadow-md animate-bounce">
                <i data-feather="check-circle" class="w-16 h-16 text-green-600"></i>
            </div>
            <h3 class="text-3xl font-bold text-slate-900 mb-4">Application Received!</h3>
            <p class="text-slate-600 text-lg max-w-sm mx-auto mb-8">Thank you for your interest in joining ASK 33. We have received your details and will review your application shortly.</p>
            <button onclick="resetForm()" class="px-6 py-2 border border-blue-600 text-blue-600 rounded-full font-bold hover:bg-blue-50 transition">Send another application</button>
        </div>

    </div>
</div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

  <footer class="bg-gray-100 text-gray-500 py-12 text-center mt-12 border-t border-gray-200">
        <div class="flex flex-col items-center justify-center mb-6">
             <img src="<?php echo get_template_directory_uri(); ?>/images/One-Guide.png" alt="Logo" class="h-16 w-auto opacity-90 object-contain">
             <span class="brand-text text-gray-800 mt-2 text-xl font-bold">One Guide</span>
             <a href="https://www.ask33.co.uk/" target="_blank" class="text-[10px] text-gray-400 font-bold hover:text-red-600 transition mt-1 uppercase">Powered by ASK 33</a>
        </div>
        <p class="text-sm">Site by <a href="https://www.alphaitsolutions.uk" target="_blank" class="text-blue-500 hover:text-red-700 font-bold transition">Alpha IT Solutions</a></p>
        <p class="text-xs mt-2 opacity-50">&copy; 2026 One Guide Advisors.</p>
    </footer>
    <script>
        feather.replace();

        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('active');
        }

        const dict = {
            en: {
                nav_courses: "Courses", nav_team: "Advisors", nav_reviews: "Reviews", btn_apply_nav: "Apply Now", nav_tagline: "We help you find the right direction",
                page_title: "Join Ask33 Team", page_sub: "Student Advisor (100% Remote)",
                role_title: "Role Overview", role_desc: "In my role as Team Leader at Ask33, I am expanding my team and looking for involved, persistent, and motivated people who want to work as a Student Advisor. This collaboration is ideal if you want to work from home, have a flexible schedule, and work in a stable, well-paid field.",
                ben_1: "High Earnings", ben_1_d: "Up to £1,200 per student.", ben_2: "100% Remote", ben_2_d: "Work from anywhere.", ben_3: "Flexible", ben_3_d: "No fixed hours, no stress.", ben_4: "Growth", ben_4_d: "Real possibility of growth.",
                resp_title: "What the Role Involves:", resp_1: "Constant posting on social media.", resp_2: "Communicating with people interested in university.", resp_3: "Guiding applicants through the registration process.", resp_4: "Maintaining contact with students during application.",
                offer_title: "What I Offer You:", no_exp: "No experience? No problem. Full training provided.", off_1: "Clear, structured training.", off_2: "Continuous support and feedback.", off_3: "Work strategies that actually work.", off_4: "Friendly environment and united team.",
                form_title: "Apply Now", form_sub: "Send me a message with your details. Limited spots available.",
                lbl_name: "Full Name", lbl_phone: "Phone", lbl_email: "Email", lbl_link: "Social / LinkedIn", lbl_cv: "Upload CV / Resume", btn_upload: "Click to upload", lbl_why: "Why do you want to join?", btn_apply: "Submit Application"
            },
            ro: {
                nav_courses: "Cursuri", nav_team: "Echipă", nav_reviews: "Recenzii", btn_apply_nav: "Aplică Acum", nav_tagline: "Te ajutăm să găsești direcția potrivită",
                page_title: "Alătură-te Echipei Ask33", page_sub: "Student Advisor (100% Remote)",
                role_title: "Prezentare Rol", role_desc: "În rolul meu de Team Leader în cadrul Ask33, îmi extind echipa și caut persoane implicate, perseverente și motivate, care își doresc să lucrezi ca Student Advisor, 100% remote. Această colaborare este ideală pentru tine dacă vrei să lucrezi de acasă, să ai program flexibil și să activezi într-un domeniu curat, stabil și bine plătit.",
                ben_1: "Câștiguri Mari", ben_1_d: "Până la £1,200 per student.", ben_2: "100% Remote", ben_2_d: "Lucrezi de oriunde.", ben_3: "Flexibil", ben_3_d: "Fără program fix, fără stres.", ben_4: "Creștere", ben_4_d: "Posibilitate reală de creștere.",
                resp_title: "Ce presupune rolul:", resp_1: "Postarea constantă pe rețelele de socializare.", resp_2: "Comunicarea cu persoanele interesate de universitate.", resp_3: "Ghidarea aplicanților către procesul de înscriere.", resp_4: "Menținerea legăturii cu studenții pe parcursul aplicării.",
                offer_title: "Ce îți ofer eu:", no_exp: "Nu ai experiență? Nicio problemă. Primești training complet.", off_1: "Instruire clară, structurată.", off_2: "Suport continuu și feedback.", off_3: "Strategii de lucru care chiar funcționează.", off_4: "Mediu prietenos și echipă unită.",
                form_title: "Aplică Acum", form_sub: "Trimite-mi un mesaj cu detaliile tale. Locuri limitate.",
                lbl_name: "Nume Complet", lbl_phone: "Telefon", lbl_email: "Email", lbl_link: "Social / LinkedIn", lbl_cv: "Încarcă CV / Resume", btn_upload: "Apasă pentru încărcare", lbl_why: "De ce vrei să te alături?", btn_apply: "Trimite Aplicația"
            },
            pl: {
                nav_courses: "Kursy", nav_team: "Zespół", nav_reviews: "Opinie", btn_apply_nav: "Aplikuj", nav_tagline: "Pomożemy Ci znaleźć właściwy kierunek",
                page_title: "Dołącz do Zespołu", page_sub: "Doradca Studenta (Zdalnie)",
                role_title: "Przegląd Roli", role_desc: "Rozszerzam zespół o zaangażowane osoby. Praca idealna dla tych, którzy chcą pracować z domu, mieć elastyczny grafik i stabilne dochody.",
                ben_1: "Wysokie Zarobki", ben_1_d: "Do £1,200 za studenta.", ben_2: "Zdalnie", ben_2_d: "Praca z domu.", ben_3: "Elastyczność", ben_3_d: "Bez stresu.", ben_4: "Rozwój", ben_4_d: "Realna szansa rozwoju.",
                resp_title: "Obowiązki:", resp_1: "Publikowanie w mediach społecznościowych.", resp_2: "Komunikacja z zainteresowanymi.", resp_3: "Prowadzenie przez proces rekrutacji.", resp_4: "Utrzymywanie kontaktu ze studentami.",
                offer_title: "Co oferuję:", no_exp: "Brak doświadczenia? Pełne szkolenie zapewnione.", off_1: "Jasne szkolenie.", off_2: "Ciągłe wsparcie.", off_3: "Sprawdzone strategie.", off_4: "Przyjazna atmosfera.",
                form_title: "Aplikuj Teraz", form_sub: "Miejsca ograniczone.",
                lbl_name: "Imię i Nazwisko", lbl_phone: "Telefon", lbl_email: "Email", lbl_link: "Social / LinkedIn", lbl_cv: "Załaduj CV", btn_upload: "Prześlij", lbl_why: "Dlaczego chcesz dołączyć?", btn_apply: "Wyślij Aplikację"
            },
            hu: {
                nav_courses: "Tanfolyamok", nav_team: "Csapat", nav_reviews: "Vélemények", btn_apply_nav: "Jelentkezés", nav_tagline: "Segítünk megtalálni a helyes irányt",
                page_title: "Csatlakozz a Csapathoz", page_sub: "Diáktanácsadó (Távmunka)",
                role_title: "Szerep Áttekintése", role_desc: "Bővítem a csapatot motivált emberekkel. Ideális otthoni munkára, rugalmas időbeosztással.",
                ben_1: "Magas Kereset", ben_1_d: "Akár £1,200 diákonként.", ben_2: "Távmunka", ben_2_d: "Bárhonnan dolgozhatsz.", ben_3: "Rugalmas", ben_3_d: "Nincs fix munkaidő.", ben_4: "Fejlődés", ben_4_d: "Valós fejlődési lehetőség.",
                resp_title: "Feladatok:", resp_1: "Posztolás közösségi médiában.", resp_2: "Kommunikáció érdeklődőkkel.", resp_3: "Jelentkezési folyamat segítése.", resp_4: "Kapcsolattartás diákokkal.",
                offer_title: "Amit kínálok:", no_exp: "Nincs tapasztalat? Teljes képzést biztosítunk.", off_1: "Világos képzés.", off_2: "Folyamatos támogatás.", off_3: "Működő stratégiák.", off_4: "Barátságos környezet.",
                form_title: "Jelentkezz Most", form_sub: "Korlátozott helyek.",
                lbl_name: "Teljes Név", lbl_phone: "Telefon", lbl_email: "Email", lbl_link: "Social / LinkedIn", lbl_cv: "CV Feltöltése", btn_upload: "Feltöltés", lbl_why: "Miért szeretnél csatlakozni?", btn_apply: "Jelentkezés Küldése"
            },
            es: {
                nav_courses: "Cursos", nav_team: "Equipo", nav_reviews: "Reseñas", btn_apply_nav: "Aplica Ya", nav_tagline: "Te ayudamos a encontrar el camino",
                page_title: "Únete al Equipo", page_sub: "Asesor Estudiantil (Remoto)",
                role_title: "Descripción del Rol", role_desc: "Estoy expandiendo mi equipo. Busco personas motivadas para trabajar desde casa con horario flexible.",
                ben_1: "Altos Ingresos", ben_1_d: "Hasta £1,200 por estudiante.", ben_2: "Remoto", ben_2_d: "Trabaja desde cualquier lugar.", ben_3: "Flexible", ben_3_d: "Sin horario fijo.", ben_4: "Crecimiento", ben_4_d: "Posibilidad real de crecimiento.",
                resp_title: "Responsabilidades:", resp_1: "Publicar en redes sociales.", resp_2: "Comunicación con interesados.", resp_3: "Guía en el proceso de inscripción.", resp_4: "Mantener contacto con estudiantes.",
                offer_title: "Lo que ofrezco:", no_exp: "¿Sin experiencia? Entrenamiento completo incluido.", off_1: "Formación clara.", off_2: "Apoyo continuo.", off_3: "Estrategias efectivas.", off_4: "Ambiente amigable.",
                form_title: "Aplica Ahora", form_sub: "Plazas limitadas.",
                lbl_name: "Nombre Completo", lbl_phone: "Teléfono", lbl_email: "Email", lbl_link: "Social / LinkedIn", lbl_cv: "Subir CV", btn_upload: "Clic para subir", lbl_why: "¿Por qué quieres unirte?", btn_apply: "Enviar Solicitud"
            },
            it: {
                nav_courses: "Corsi", nav_team: "Team", nav_reviews: "Recensioni", btn_apply_nav: "Candidati", nav_tagline: "Ti aiutiamo a trovare la strada giusta",
                page_title: "Unisciti al Team", page_sub: "Student Advisor (Remoto)",
                role_title: "Panoramica del Ruolo", role_desc: "Sto espandendo il mio team. Cerco persone motivate per lavorare da casa con orari flessibili.",
                ben_1: "Guadagni Alti", ben_1_d: "Fino a £1,200 per studente.", ben_2: "Remoto", ben_2_d: "Lavora ovunque.", ben_3: "Flessibile", ben_3_d: "Nessun orario fisso.", ben_4: "Crescita", ben_4_d: "Reale possibilità di crescita.",
                resp_title: "Cosa comporta il ruolo:", resp_1: "Pubblicazione sui social media.", resp_2: "Comunicazione con gli interessati.", resp_3: "Guida al processo di iscrizione.", resp_4: "Mantenere i contatti.",
                offer_title: "Cosa offro:", no_exp: "Nessuna esperienza? Formazione completa fornita.", off_1: "Formazione chiara.", off_2: "Supporto continuo.", off_3: "Strategie efficaci.", off_4: "Ambiente amichevole.",
                form_title: "Candidati Ora", form_sub: "Posti limitati.",
                lbl_name: "Nome Completo", lbl_phone: "Telefono", lbl_email: "Email", lbl_link: "Social / LinkedIn", lbl_cv: "Carica CV", btn_upload: "Clicca per caricare", lbl_why: "Perché vuoi unirti?", btn_apply: "Invia Candidatura"
            },
            pt: {
                nav_courses: "Cursos", nav_team: "Equipe", nav_reviews: "Avaliações", btn_apply_nav: "Candidate-se", nav_tagline: "Ajudamos você a encontrar o caminho certo",
                page_title: "Junte-se à Equipe", page_sub: "Consultor Estudantil (Remoto)",
                role_title: "Visão Geral", role_desc: "Estou expandindo minha equipe. Procuro pessoas motivadas para trabalho remoto flexível.",
                ben_1: "Ganhos Altos", ben_1_d: "Até £1,200 por aluno.", ben_2: "Remoto", ben_2_d: "Trabalhe de qualquer lugar.", ben_3: "Flexível", ben_3_d: "Sem horário fixo.", ben_4: "Crescimento", ben_4_d: "Possibilidade real de crescimento.",
                resp_title: "Responsabilidades:", resp_1: "Postagens em redes sociais.", resp_2: "Comunicação com interessados.", resp_3: "Orientação na inscrição.", resp_4: "Manter contato.",
                offer_title: "O que ofereço:", no_exp: "Sem experiência? Treinamento completo.", off_1: "Treinamento claro.", off_2: "Suporte contínuo.", off_3: "Estratégias eficazes.", off_4: "Ambiente amigável.",
                form_title: "Candidate-se Agora", form_sub: "Vagas limitadas.",
                lbl_name: "Nome Completo", lbl_phone: "Telefone", lbl_email: "Email", lbl_link: "Social / LinkedIn", lbl_cv: "Enviar CV", btn_upload: "Clique para enviar", lbl_why: "Por que você quer se juntar?", btn_apply: "Enviar Candidatura"
            },
            el: {
                nav_courses: "Μαθήματα", nav_team: "Ομάδα", nav_reviews: "Κριτικές", btn_apply_nav: "Αίτηση", nav_tagline: "Σας βοηθάμε να βρείτε τη σωστή κατεύθυνση",
                page_title: "Γίνετε Μέλος της Ομάδας", page_sub: "Σύμβουλος Φοιτητών (Εξ αποστάσεως)",
                role_title: "Επισκόπηση Ρόλου", role_desc: "Επεκτείνω την ομάδα μου. Ψάχνω άτομα με κίνητρο για εργασία από το σπίτι.",
                ben_1: "Υψηλές Αποδοχές", ben_1_d: "Έως £1,200 ανά φοιτητή.", ben_2: "Εξ αποστάσεως", ben_2_d: "Εργασία από παντού.", ben_3: "Ευέλικτο", ben_3_d: "Χωρίς σταθερό ωράριο.", ben_4: "Ανάπτυξη", ben_4_d: "Πραγματική δυνατότητα εξέλιξης.",
                resp_title: "Αρμοδιότητες:", resp_1: "Αναρτήσεις στα social media.", resp_2: "Επικοινωνία με ενδιαφερόμενους.", resp_3: "Καθοδήγηση εγγραφής.", resp_4: "Διατήρηση επαφής.",
                offer_title: "Τι προσφέρω:", no_exp: "Χωρίς εμπειρία; Παρέχεται πλήρης εκπαίδευση.", off_1: "Σαφής εκπαίδευση.", off_2: "Συνεχής υποστήριξη.", off_3: "Αποτελεσματικές στρατηγικές.", off_4: "Φιλικό περιβάλλον.",
                form_title: "Κάντε Αίτηση Τώρα", form_sub: "Περιορισμένες θέσεις.",
                lbl_name: "Ονοματεπώνυμο", lbl_phone: "Τηλέφωνο", lbl_email: "Email", lbl_link: "Social / LinkedIn", lbl_cv: "Μεταφόρτωση CV", btn_upload: "Κλικ για μεταφόρτωση", lbl_why: "Γιατί θέλετε να συμμετέχετε;", btn_apply: "Υποβολή Αίτησης"
            },
            bg: {
                nav_courses: "Курсове", nav_team: "Екип", nav_reviews: "Отзиви", btn_apply_nav: "Кандидатствай", nav_tagline: "Ние ви помагаме да намерите правилната посока",
                page_title: "Присъедини се към Екипа", page_sub: "Студентски Съветник (Дистанционно)",
                role_title: "Преглед на Ролята", role_desc: "Разширявам екипа си. Търся мотивирани хора за работа от вкъщи с гъвкав график.",
                ben_1: "Високи Доходи", ben_1_d: "До £1,200 на студент.", ben_2: "Дистанционно", ben_2_d: "Работа от всякъде.", ben_3: "Гъвкав", ben_3_d: "Без фиксирано време.", ben_4: "Растеж", ben_4_d: "Реална възможност за растеж.",
                resp_title: "Отговорности:", resp_1: "Публикуване в социалните мрежи.", resp_2: "Комуникация със заинтересовани.", resp_3: "Насочване при записване.", resp_4: "Поддържане на контакт.",
                offer_title: "Какво предлагам:", no_exp: "Без опит? Пълно обучение е осигурено.", off_1: "Ясно обучение.", off_2: "Непрекъсната подкрепа.", off_3: "Ефективни стратегии.", off_4: "Приятелска среда.",
                form_title: "Кандидатствай Сега", form_sub: "Ограничени места.",
                lbl_name: "Пълно Име", lbl_phone: "Телефон", lbl_email: "Имейл", lbl_link: "Social / LinkedIn", lbl_cv: "Качване на CV", btn_upload: "Кликнете за качване", lbl_why: "Защо искате да се присъедините?", btn_apply: "Изпрати Молба"
            }
        };
// Ensure icons load
    if (typeof feather !== 'undefined') feather.replace();

    const form = document.getElementById('join-team-form');
    const formWrapper = document.getElementById('application-form-wrapper');
    const successMessage = document.getElementById('success-message');
    const submitBtn = document.getElementById('submit-btn');
    const btnText = document.getElementById('btn-text');
    const btnIcon = document.getElementById('btn-icon');
    const btnSpinner = document.getElementById('btn-spinner');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        submitBtn.disabled = true;
        btnText.textContent = "Sending...";
        btnIcon.classList.add('hidden');
        btnSpinner.classList.remove('hidden');

        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (response.ok) {
                formWrapper.style.opacity = '0';
                formWrapper.style.transform = 'translateY(-20px)';
                
                // Wait for fade, then show success message
                setTimeout(() => {
                    formWrapper.classList.add('hidden');
                    successMessage.classList.remove('pointer-events-none');
                    successMessage.classList.remove('translate-y-10'); // Slide up
                    successMessage.style.opacity = '1';
                    
                    if (typeof feather !== 'undefined') feather.replace();
                }, 500);
            } else {
                alert("Oops! There was a problem submitting your application. Please try again.");
                resetBtnState();
            }
        })
        .catch(error => {
            alert("Network error. Please check your connection.");
            resetBtnState();
        });
    });

    function resetBtnState() {
        submitBtn.disabled = false;
        btnText.textContent = "Submit Application";
        btnIcon.classList.remove('hidden');
        btnSpinner.classList.add('hidden');
    }

    function resetForm() {
        form.reset();
        document.getElementById('file-chosen').textContent = ""; // Clear file name text
        resetBtnState();

        // Reverse Animation
        successMessage.style.opacity = '0';
        successMessage.classList.add('translate-y-10');
        successMessage.classList.add('pointer-events-none');

        setTimeout(() => {
            formWrapper.classList.remove('hidden');
            setTimeout(() => {
                formWrapper.style.opacity = '1';
                formWrapper.style.transform = 'translateY(0)';
            }, 50);
        }, 500);
    }
        function changeLanguage(lang) {
            const t = dict[lang] || dict['en'];
            document.querySelectorAll('[data-key]').forEach(el => {
                const k = el.getAttribute('data-key');
                if(t[k]) {
                    if(el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') el.placeholder = t[k];
                    else el.innerText = t[k];
                }
            });
        }
    </script>
</body>
</html>
