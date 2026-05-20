<?php



if (!function_exists('get_template_directory_uri')) {
    function get_template_directory_uri() { return '.'; }
}
if (!function_exists('home_url')) {
    function home_url($path = '') { return '/' . ltrim($path, '/'); }
}

$baseDir = __DIR__;

$configFile = $baseDir . '/config.json';
$googleMapsKey = "";
$geminiApiKey = "";

if (file_exists($configFile)) {
    $configData = json_decode(file_get_contents($configFile), true);
    $googleMapsKey = $configData['googleMapsKey'] ?? "";
    $geminiApiKey = $configData['geminiApiKey'] ?? "";
}

$jsonFiles = ['courses.json'];
$allCourses = [];
$jsonErrors = [];

foreach ($jsonFiles as $file) {
    $filePath = $baseDir . '/' . $file;
    if (file_exists($filePath)) {
        $content = file_get_contents($filePath);
        $data = json_decode($content, true);
        
        if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
            $allCourses = array_merge($allCourses, $data);
        } else {
            $jsonErrors[] = "Error loading $file: " . json_last_error_msg();
        }
    }
}

$coursesJson = json_encode($allCourses);
$phpErrorsJson = json_encode($jsonErrors);

$web3FormsKey = "{your api here}"; 
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Casandra Banu | UK University Admissions Consultant & Team Leader</title>
    <meta name="title" content="Casandra Banu | UK University Admissions Consultant & Team Leader">
    <meta name="description" content="Expert guidance for UK university admissions and Student Finance. Casandra Banu offers 100% free consultancy for applications, interviews, and enrollment. Start today!">
    <meta name="keywords" content="Casandra Banu, UK university admissions, Student Finance England, educational consultant, study in the UK, university application help, remote student advisor jobs">
    <meta name="author" content="Casandra Banu">
    <link rel="canonical" href="https://www.one-guide.co.uk/casandra-banu/">

    <meta property="og:type" content="profile">
    <meta property="og:url" content="https://www.one-guide.co.uk/casandra-banu/">
    <meta property="og:title" content="Casandra Banu | UK University Admissions Consultant">
    <meta property="og:description" content="Expert guidance for UK university admissions and Student Finance. Casandra Banu offers 100% free consultancy for applications, interviews, and enrollment.">
    <meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/images/CasandraBanu.jpg">
    <meta property="profile:first_name" content="Casandra">
    <meta property="profile:last_name" content="Banu">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://www.one-guide.co.uk/casandra-banu/">
    <meta property="twitter:title" content="Casandra Banu | UK University Admissions Consultant">
    <meta property="twitter:description" content="Expert guidance for UK university admissions and Student Finance. Get 100% free consultancy for your university application.">
    <meta property="twitter:image" content="<?php echo get_template_directory_uri(); ?>/images/CasandraBanu.jpg">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Lora:wght@400;600&display=swap" rel="stylesheet">
    <script type="application/ld+json">
    {
      "@context": "https://schema.org/",
      "@type": "Person",
      "name": "Casandra Banu",
      "jobTitle": "Team Leader & Educational Consultant",
      "worksFor": {
        "@type": "EducationalOrganization",
        "name": "Ask33 / One Guide"
      },
      "url": "https://www.one-guide.co.uk/casandra-banu/",
      "image": "https://www.one-guide.co.uk/images/CasandraBanu.jpg",
      "description": "Team Leader and Educational Consultant supporting students to start or continue university studies in the UK with expert Student Finance guidance.",
      "sameAs": [
        "https://www.facebook.com/kss.andra.77",
        "https://www.linkedin.com/in/casandra-banu",
        "https://www.tiktok.com/@cassandra.ask33"
      ]
    }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
    <script>pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.4.21/mammoth.browser.min.js"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Lora:wght@400;600&display=swap" rel="stylesheet">

    <?php if (!empty($googleMapsKey)): ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo htmlspecialchars($googleMapsKey); ?>&libraries=geometry" async defer></script>
    <?php endif; ?>

     <style>
        :root {
            --primary: #1e3a8a; /* Oxford Blue */
            --accent: #2563eb;  /* Brighter Blue */
            --coral: #ff7f7f;   /* Accent Color */
            --text-main: #1e293b;
            --border-color: #e2e8f0;
        }
        
 body { font-family: 'Lato', sans-serif; color: var(--text-main); overflow-x: hidden; position: relative; background-color: #f8fafc; }
        h1, h2, h3, .serif-font { font-family: 'Playfair Display', serif; }
        
        .footer-socials { gap: 1rem; } 
        .footer-socials a { 
            display: inline-flex; 
            align-items: center; 
            justify-content: center; 
            width: 50px; 
            height: 50px; 
            border-radius: 50%; 
            background: #f8fafc; /* Light gray background initially */
            transition: all 0.3s ease; 
            font-size: 1.6rem; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .footer-socials a:hover { 
            transform: translateY(-4px); 
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .icon-fb { color: #1877F2; } /* Facebook Blue */
        .icon-fb:hover { background: #1877F2; color: white; }

        .icon-wa { color: #25D366; } /* WhatsApp Green */
        .icon-wa:hover { background: #25D366; color: white; }

        .icon-mail { color: #475569; } /* Standard Slate for Email */
        .icon-mail:hover { background: #475569; color: white; }
        #bg-fixed { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -2; background-image: url('<?php echo get_template_directory_uri(); ?>/images/background.png'); background-position: center center; background-repeat: no-repeat; background-size: cover; }
        #bg-veil { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(4px); }
        
        nav { background: rgba(255, 255, 255, 0.95); border-bottom: 1px solid var(--border-color); box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .fade-in { animation: fadeIn 0.8s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        
        .content-card { background: #ffffff; border-radius: 1.5rem; padding: 2.5rem; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05); border: 1px solid var(--border-color); }
        
        .input-standard { background: #f9fafb; border: 1px solid #d1d5db; color: #1f2937; border-radius: 0.5rem; padding: 0.75rem; width: 100%; transition: all 0.2s; }
        .input-standard:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1); outline: none; background: #ffffff; }
        
        .btn-blue { background-color: var(--primary); color: white; padding: 12px 30px; border-radius: 8px; font-weight: 700; transition: transform 0.2s, background-color 0.2s; display: inline-block; cursor: pointer; text-align: center; }
        .btn-blue:hover { background-color: #1e40af; transform: translateY(-2px); }
        .btn-outline-blue { background: transparent; border: 2px solid var(--primary); color: var(--primary); padding: 10px 28px; border-radius: 8px; font-weight: 700; transition: all 0.2s; display: inline-block; text-align: center; }
        .btn-outline-blue:hover { background: var(--primary); color: white; }

        .prep-card { background: #ffffff; border: 1px solid #e2e8f0; color: var(--primary); padding: 2rem; border-radius: 1rem; transition: transform 0.2s; display: block; text-align: center; height: 100%; }
        .prep-card:hover { transform: translateY(-5px); border-color: var(--primary); box-shadow: 0 10px 20px rgba(30, 58, 138, 0.1); }

        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; display: none; justify-content: center; align-items: center; padding: 20px; }
        .modal-content { background: white; width: 100%; max-width: 600px; border-radius: 1rem; padding: 30px; position: relative; max-height: 90vh; overflow-y: auto; animation: slideUp 0.3s ease; }
        @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

        #mobile-menu { display: none; position: absolute; top: 100%; left: 0; width: 100%; background: white; border-top: 1px solid #e2e8f0; flex-direction: column; padding: 1rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); z-index: 40; animation: slideDown 0.3s ease-out; }
        #mobile-menu.active { display: flex; }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

        footer { background: #ffffff; color: var(--text-main); border-top: 1px solid var(--border-color); }
        
        .pagination-btn { padding: 8px 16px; background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 6px; font-weight: 600; color: #334155; transition: all 0.2s; }
        .pagination-btn:hover:not(:disabled) { background: #e2e8f0; color: #0f172a; }
        .pagination-btn:disabled { opacity: 0.5; cursor: not-allowed; }
    </style>
</head>
<body class="bg-transparent">

 <div id="bg-fixed"></div>
    <div id="bg-veil"></div>
    <nav class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-28 flex justify-between items-center relative">
            
          <a href="index.php" class="flex flex-col items-center justify-center gap-0 group no-underline">
                <img src="<?php echo get_template_directory_uri(); ?>/images/One-Guide.png" alt="Logo" class="h-10 w-auto object-contain mb-1 transition group-hover:scale-105">
                
                <span class="brand-text text-sm font-bold text-blue-900 leading-tight">One Guide</span>
                <span class="text-sm font-medium text-gray-700">We help you find the right direction</span>

                <span class="text-[9px] font-bold text-blue-900 tracking-wide uppercase mt-0.5">
                    Powered by <span class="hover:text-red-600 active:text-red-700 transition-colors cursor-pointer" onclick="window.open('https://www.ask33.co.uk/', '_blank')">ASK 33</span>
                </span>
            </a>

            <div class="hidden md:flex gap-8 items-center font-medium text-gray-600">
                <a href="#course-search" class="hover:text-[#1e3a8a] transition" data-key="nav_courses">Courses</a>
                <a href="#about" class="hover:text-[#1e3a8a] transition" data-key="nav_about">About</a>
                <a href="#join-team" class="hover:text-[#1e3a8a] transition" data-key="nav_join">Join Team</a>
                              
                <div class="relative inline-block">
                    <select onchange="changeLanguage(this.value)" class="input-standard py-2 pl-3 pr-8 text-sm bg-white border-gray-200 cursor-pointer">
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
                
                <a href="#contact" class="btn-blue shadow-md" data-key="nav_contact">Contact</a>
            </div>

            <button class="md:hidden p-2 text-slate-600 border border-slate-300 rounded-lg hover:bg-slate-100 transition" onclick="toggleMobileMenu()">
                <i data-feather="menu"></i>
            </button>

            <div id="mobile-menu">
                <a href="#course-search" class="block py-2 font-medium text-gray-600 hover:text-[#1e3a8a]" data-key="nav_courses">Courses</a>
                <a href="#about" class="block py-2 font-medium text-gray-600 hover:text-[#1e3a8a]" data-key="nav_about">About</a>
                <a href="#join-team" class="block py-2 font-medium text-gray-600 hover:text-[#1e3a8a]" data-key="nav_join">Join Team</a>            
                <div class="border-t border-gray-100 pt-4 mt-2">
                    <select onchange="changeLanguage(this.value); toggleMobileMenu();" class="w-full p-3 border border-gray-300 rounded bg-white text-gray-700">
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
                <a href="#contact" class="btn-blue w-full mt-4 text-center" data-key="nav_contact">Contact</a>
            </div>
        </div>
    </nav>

    <main>
       <section class="pt-40 pb-24 px-6 border-b border-gray-100/50">
    <div class="max-w-5xl mx-auto flex flex-col md:flex-row items-center gap-12 fade-in hero-content">
        
        <div class="relative shrink-0 hero-img">
            <div class="absolute inset-0 bg-blue-500 blur-xl opacity-20 rounded-full"></div>
            <img src="<?php echo get_template_directory_uri(); ?>/images/CasandraBanu.jpg" alt="Casandra Banu" class="relative w-64 h-64 rounded-full border-4 border-white shadow-2xl object-cover">
        </div>

        <div class="text-center md:text-left">
            <h1 class="text-5xl font-bold text-slate-900 mb-2">Casandra Banu</h1>
            <p class="text-blue-600 font-bold tracking-widest uppercase mb-6" data-key="role">Team Leader & Educational Consultant</p>
            <p class="text-lg text-slate-600 mb-8 max-w-xl leading-relaxed italic" data-key="hero_slogan">
                "Unlock your academic success with expert guidance."
            </p>  

            <div class="flex flex-wrap gap-6 justify-center md:justify-start mb-8">
                <div class="flex items-center gap-2 text-gray-600 font-medium">
                    <i data-feather="phone" class="w-4 h-4 text-[#1e3a8a]"></i> 07470 788942
                </div>
                <div class="flex items-center gap-2 text-gray-600 font-medium">
                    <i data-feather="mail" class="w-4 h-4 text-[#1e3a8a]"></i> Casandra.Banu@ask33.co.uk
                </div>
            </div>                                

            <div class="flex flex-wrap gap-4 justify-center md:justify-start">
                <a href="#contact" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-700 shadow-lg transition" data-key="btn_student">Start Studying</a>
                <a href="#join-team" class="bg-white text-blue-600 border border-blue-200 px-8 py-3 rounded-xl font-bold hover:bg-blue-50 shadow-md transition" data-key="btn_join">Join My Team</a>
                <a href="<?php echo home_url('/#team'); ?>" class="bg-transparent border-2 border-blue-600 text-blue-600 px-8 py-3 rounded-xl font-bold hover:bg-blue-600 hover:text-white transition shadow-md" data-key="btn_back">
                    Back to Team
                </a>
            </div>
        </div> </div> </section>

        <section id="course-search" class="px-6 relative z-10 -mt-4">
            <div class="max-w-5xl mx-auto content-card fade-in text-center p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold serif-font text-[#1e3a8a]" data-key="search_title">Search Accredited Courses</h2>
                    <button id="toggle-search-btn" onclick="document.getElementById('search-container').classList.toggle('hidden')" class="text-sm text-[#1e3a8a] underline">Hide Search</button>
                </div>
                
                <div id="search-container">
                    <form onsubmit="handleSearch(event)" class="grid md:grid-cols-4 gap-6 text-left">
                         <div class="md:col-span-1">
                    <label class="text-xs font-bold uppercase mb-2 block" data-key="lbl_postcode">City</label>
                    <select id="user-postcode" class="input-standard w-full" required>
                        <option value="" disabled selected>Select a city</option>
                       
                        <option value="Online">Online / Self-Learning</option>
                        <option value="London">London</option>
                        <option value="Manchester">Manchester</option>
                        <option value="Birmingham">Birmingham</option>
                        <option value="Leeds">Leeds</option>
                        <option value="Bradford">Bradford</option>
                        <option value="Sheffield">Sheffield</option>
                        <option value="Nottingham">Nottingham</option>                                     <option value="Newcastle">Newcastle</option>
                        <option value="Leicester">Leicester</option>
                       
                    </select>
                </div>
                
          <div>
                        <label class="text-xs font-bold uppercase mb-2 block text-gray-500" data-key="lbl_level">Level</label>
                        <select id="user-level" class="input-standard w-full">
                            <option value="All">All Levels</option>
                            <option value="Foundation">Foundation Year</option>
                            <option value="Year 1">Year 1 (Level 4)</option>
                            <option value="Year 2">Year 2 (Level 5)</option>
                            <option value="Top-up">Top-up (Level 6)</option>
                            <option value="Master">Master / Postgraduate</option>
                            <option value="Second Degree">Second Degree</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-bold uppercase mb-2 block text-gray-500" data-key="lbl_subject">Subject</label>
                        <select id="user-subject" class="input-standard w-full">
                            <option value="All">All Subjects</option>
                            <option value="Business">Business</option>
                            <option value="Computing">Computing</option>
                            <option value="Health">Health & Social Care</option>
                            <option value="Law">Law</option>
                            <option value="Art">Art & Design</option>
                            <option value="Hospitality">Hospitality</option>
                            <option value="Education">Education</option>
                        </select>
                    </div>
                        <div class="flex items-end">
                            <button class="w-full btn-blue" data-key="btn_find">Find</button>
                        </div>
                    </form>
                    
                     <div id="loading-spinner" class="hidden mt-6 text-blue-600 font-bold animate-pulse">Searching...</div>
            
            <div id="results-area" class="mt-8 space-y-4 text-left"></div>
            
            <div id="pagination-controls" class="hidden mt-6 flex justify-center gap-4">
                <button onclick="changePage(-1)" class="px-4 py-2 bg-gray-100 border rounded hover:bg-gray-200 transition">Previous</button>
                <span id="page-indicator" class="px-4 py-2 font-bold text-gray-700">Page 1</span>
                <button onclick="changePage(1)" class="px-4 py-2 bg-gray-100 border rounded hover:bg-gray-200 transition">Next</button>
            </div>
            
        </div>
    </section>


        <section id="about" class="py-20 px-6">
        <section id="about" class="py-20 px-6">
    <div class="max-w-6xl mx-auto glass-effect p-8 md:p-10 rounded-3xl shadow-xl border border-slate-100">
        
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-slate-900" data-key="about_title">About Me</h2>
            <p class="text-slate-500 mt-2" data-key="about_sub">Proven expertise, guaranteed results.</p>
        </div>

        <div class="grid lg:grid-cols-2 gap-12">
            
            <div class="space-y-6 text-slate-700 text-lg leading-relaxed">
                <p data-key="bio_p1">"I am Casandra Banu, Team Leader and Educational Consultant at Ask33, an agency dedicated to supporting students who wish to start or continue their university studies in the UK. With a firm and well-structured approach, I offer A-to-Z consulting and guidance in the university admission process across the most prestigious cities in the UK, including London, Newcastle, Nottingham, Manchester, Leeds, and Birmingham."</p>
                
                <div class="bg-blue-50 p-6 rounded-xl border-l-4 border-blue-600 italic text-slate-800">
                    <p data-key="bio_quote">"With considerable experience in counseling students applying based on diplomas or work experience, I have helped numerous individuals choose their ideal academic path, successfully navigate admission requirements, and secure a place at top UK universities."</p>
                </div>
                
                <p data-key="bio_p2">"I understand that time and flexibility are essential. That's why I offer you the opportunity to study in a format that fits your schedule: online, on-campus, daytime, evening, or weekend. You can even choose to study just two days a week, allowing you to balance your personal and professional life without compromises. Choose success! Don't leave your education to chance. Contact me today and start your journey toward a successful university future!"</p>
            </div>

            <div class="space-y-8">
                <div class="bg-blue-50 p-8 rounded-2xl border border-blue-100 h-fit shadow-sm">
                    <h4 class="font-bold text-xl text-blue-900 mb-6" data-key="why_title">Why Work With Me?</h4>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3"><i data-feather="check-circle" class="text-blue-600 mt-1 shrink-0"></i> <span data-key="why_1">Professional approach</span></li>
                        <li class="flex items-start gap-3"><i data-feather="check-circle" class="text-blue-600 mt-1 shrink-0"></i> <span data-key="why_2">Real field experience</span></li>
                        <li class="flex items-start gap-3"><i data-feather="check-circle" class="text-blue-600 mt-1 shrink-0"></i> <span data-key="why_3">Clear communication</span></li>
                        <li class="flex items-start gap-3"><i data-feather="check-circle" class="text-blue-600 mt-1 shrink-0"></i> <span data-key="why_4">Constant support</span></li>
                        <li class="flex items-start gap-3"><i data-feather="check-circle" class="text-blue-600 mt-1 shrink-0"></i> <span data-key="why_5">Free & transparent process</span></li>
                    </ul>
                </div>

                <div class="bg-green-50 p-8 rounded-2xl border border-green-100 h-fit shadow-sm">
                    <h4 class="font-bold text-xl text-green-900 mb-4" data-key="ben_title">Benefits for Students</h4>
                    <p class="text-green-800 leading-relaxed" data-key="ben_text">
                        Eligible students can benefit from: tuition fee coverage, maintenance financial support, public transport discounts, and stability throughout their studies.
                    </p>
                </div>
            </div>
        </div> <div class="mt-12 bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
            <h4 class="font-bold text-xl text-center text-blue-900 mb-8" data-key="services_title">What I Offer</h4>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="flex items-center gap-3"><i data-feather="check" class="text-blue-600"></i> <span data-key="svc_1">Free consultation</span></div>
                <div class="flex items-center gap-3"><i data-feather="check" class="text-blue-600"></i> <span data-key="svc_2">Process application</span></div>
                <div class="flex items-center gap-3"><i data-feather="check" class="text-blue-600"></i> <span data-key="svc_3">Document check</span></div>
                <div class="flex items-center gap-3"><i data-feather="check" class="text-blue-600"></i> <span data-key="svc_4">Application submission</span></div>
                <div class="flex items-center gap-3"><i data-feather="check" class="text-blue-600"></i> <span data-key="svc_5">Interview preparation</span></div>
                <div class="flex items-center gap-3"><i data-feather="check" class="text-blue-600"></i> <span data-key="svc_6">English test preparation</span></div>
                <div class="flex items-center gap-3"><i data-feather="check" class="text-blue-600"></i> <span data-key="svc_7">Enrollment support</span></div>
                <div class="flex items-center gap-3"><i data-feather="check" class="text-blue-600"></i> <span data-key="svc_8">Student finance guidance</span></div>
            </div>
        </div>

    </div> </section>
        <section id="join-team" class="py-20 px-6 bg-slate-900 text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5"></div>
            <div class="max-w-4xl mx-auto text-center relative z-10">
                <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">Recruitment</span>
                <h2 class="text-4xl font-bold mt-4 mb-6" data-key="rec_title">Join Ask33 Team – Student Advisor (Remote)</h2>
                <p class="text-slate-300 text-lg mb-10 leading-relaxed" data-key="rec_desc">
                    In my role as Team Leader at Ask33, I am expanding my team and looking for involved, persistent, and motivated people to work as Student Advisors, 100% remotely. This collaboration is ideal if you want to work from home, have a flexible schedule, and help people build a better future through education.
                </p>
                <div class="grid md:grid-cols-3 gap-6 mb-10 text-left">
                    <div class="bg-slate-800 p-6 rounded-xl border border-slate-700 hover:border-blue-500 transition">
                        <i data-feather="dollar-sign" class="text-green-400 mb-3 w-8 h-8"></i>
                        <h4 class="font-bold text-lg text-white" data-key="rec_ben_1">High Earnings</h4>
                        <p class="text-slate-400 text-sm" data-key="rec_ben_1_d">Up to £1,200 per student.</p>
                    </div>
                    <div class="bg-slate-800 p-6 rounded-xl border border-slate-700 hover:border-blue-500 transition">
                        <i data-feather="home" class="text-blue-400 mb-3 w-8 h-8"></i>
                        <h4 class="font-bold text-lg text-white" data-key="rec_ben_2">100% Remote</h4>
                        <p class="text-slate-400 text-sm" data-key="rec_ben_2_d">Work from home, flexible hours.</p>
                    </div>
                    <div class="bg-slate-800 p-6 rounded-xl border border-slate-700 hover:border-blue-500 transition">
                        <i data-feather="users" class="text-purple-400 mb-3 w-8 h-8"></i>
                        <h4 class="font-bold text-lg text-white" data-key="rec_ben_3">Full Training</h4>
                        <p class="text-slate-400 text-sm" data-key="rec_ben_3_d">Clear structure & continuous support.</p>
                    </div>
                </div>
                
                <div class="bg-slate-800/50 p-6 rounded-xl border border-slate-700 max-w-2xl mx-auto mb-10 text-left">
                    <h4 class="font-bold text-white mb-3 flex items-center gap-2"><i data-feather="check-circle" class="w-5 h-5 text-blue-400"></i> <span data-key="rec_req">You need:</span></h4>
                    <ul class="list-disc list-inside text-slate-300 space-y-1 text-sm">
                        <li>Laptop / PC</li>
                        <li>Communication skills</li>
                        <li>Motivation & Persistence</li>
                        <li>Available for weekly catch-up</li>
                    </ul>
                </div>

                <div class="text-center">
                     <a href="<?php echo home_url('/join-team/'); ?>" class="inline-flex items-center bg-blue-600 hover:bg-blue-500 text-white px-8 py-4 rounded-xl font-bold transition shadow-lg transform hover:-translate-y-1">
                        <span data-key="btn_view_job">Apply Now (Limited Spots)</span> <i data-feather="arrow-right" class="ml-2"></i>
                    </a>
                </div>
            </div>
        </section>
        <section id="prep" class="py-12 px-6">
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-bold serif-font text-[#1e3a8a]" data-key="prep_title">Interview Preparation</h2>
                    <p class="text-slate-500" data-key="prep_sub">Master the skills needed for your university interview.</p>
                </div>
                <div class="grid md:grid-cols-3 gap-8">
                    <a href="<?php echo home_url('/prep-star/'); ?>" class="prep-card group block h-full">
                        <i data-feather="star" class="w-10 h-10 text-amber-400 mb-4 mx-auto transition-transform group-hover:scale-110"></i>
                        <h3 class="text-xl font-bold mb-2 text-slate-800" data-key="star_t">STAR Method</h3>
                        <p class="text-sm text-gray-600" data-key="star_d">Master behavioral questions.</p>
                    </a>
                    <a href="<?php echo home_url('/prep-psych/'); ?>" class="prep-card group block h-full">
                        <i data-feather="cpu" class="w-10 h-10 text-blue-400 mb-4 mx-auto transition-transform group-hover:scale-110"></i>
                        <h3 class="text-xl font-bold mb-2 text-slate-800" data-key="psych_t">Ability Assessment</h3>
                        <p class="text-sm text-gray-600" data-key="psych_d">Logic & reasoning practice.</p>
                    </a>
                    <a href="<?php echo home_url('/prep-case/'); ?>" class="prep-card group block h-full">
                        <i data-feather="briefcase" class="w-10 h-10 text-purple-400 mb-4 mx-auto transition-transform group-hover:scale-110"></i>
                        <h3 class="text-xl font-bold mb-2 text-slate-800" data-key="case_t">Case Studies</h3>
                        <p class="text-sm text-gray-600" data-key="case_d">Real-world scenarios.</p>
                    </a>
                </div>
            </div>
        </section>


     <section id="eligibility" class="py-12 px-6">
            <div class="max-w-4xl mx-auto content-card bg-[#eff6ff] border border-[#1e3a8a] text-center p-10">
                <i data-feather="check-square" class="w-12 h-12 text-[#1e3a8a] mx-auto mb-4"></i>
                <h2 class="text-2xl font-bold text-[#1e3a8a] mb-4" data-key="elig_title">Check Your Eligibility</h2>
                <p class="text-gray-600 mb-6" data-key="elig_desc">Answer a few questions to see if you qualify for Student Finance and admission.</p>
                <button onclick="document.getElementById('eligibility-modal').style.display='flex'" class="btn-blue shadow-lg hover:-translate-y-1 transition" data-key="btn_check_elig">Answer Questions</button>
            </div>
        </section>

        <section id="test" class="py-12 px-6">
            <div class="max-w-4xl mx-auto content-card bg-[#f8fafc] border-l-8 border-[#1e3a8a] text-center">
                <h2 class="text-2xl font-bold text-[#1e3a8a] mb-4" data-key="test_title">Validate Your English Proficiency</h2>
                <p class="text-gray-600 mb-6" data-key="test_desc">A certified English level is often required for university admission. Take the official Duolingo English Test online anytime, anywhere.</p>
                <a href="https://englishtest.duolingo.com/applicants" target="_blank" class="inline-flex items-center gap-2 bg-[#1e3a8a] text-white px-8 py-3 rounded-lg font-bold hover:bg-[#1e40af] transition shadow-md transform hover:-translate-y-1">
                    <span data-key="btn_test">Take Duolingo English Test</span> 
                    <i data-feather="external-link" class="w-4 h-4"></i>
                </a>
            </div>
        </section>


        <section id="contact" class="py-20 px-6">
            <div class="max-w-xl mx-auto glass-effect p-8 md:p-10 rounded-2xl shadow-xl border border-slate-200">
                <div id="contact-form-wrapper" class="transition-all duration-500 ease-in-out">
                    <h2 class="text-2xl font-bold text-center text-slate-900 mb-4" data-key="contact_title">Contact Me</h2>
                    <p class="text-center text-slate-500 mb-8" data-key="contact_sub">Choose success! Contact me today.</p>
                    
                    <form id="casandra-contact-form" action="https://api.web3forms.com/submit" method="POST">
                        <input type="hidden" name="access_key" value="<?php echo $web3FormsKey; ?>">
                        <input type="checkbox" name="botcheck" class="hidden" style="display: none;">
                        <input type="hidden" name="subject" value="Contact for Casandra Banu">
                        
                        <div class="space-y-5">
                            <input type="text" name="name" class="input-standard" data-key="ph_name" placeholder="Full Name" required>
                            <input type="email" name="email" class="input-standard" data-key="ph_email" placeholder="Email Address" required>
                            <textarea name="message" rows="4" class="input-standard" data-key="ph_msg" placeholder="Message" required></textarea>
                            
                            <button type="submit" id="submit-btn" class="w-full bg-blue-600 text-white py-4 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg transform hover:-translate-y-1 flex justify-center items-center gap-2">
                                <span id="btn-text" data-key="btn_send">Send Message</span>
                                <i id="btn-icon" data-feather="send" class="w-4 h-4"></i>
                                <svg id="btn-spinner" class="animate-spin h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
                
                <div id="success-message" class="absolute inset-0 flex flex-col justify-center items-center text-center opacity-0 pointer-events-none transform translate-y-10 transition-all duration-700 ease-out">
                    <div class="bg-green-100 p-4 rounded-full mb-4 shadow-sm">
                        <i data-feather="check" class="w-12 h-12 text-green-600"></i>
                    </div>
                    <h3 class="text-3xl font-bold text-slate-800 mb-2">Thank You!</h3>
                    <p class="text-slate-600 text-lg max-w-xs mx-auto">Your message has been sent successfully. I will get back to you shortly.</p>
                    <button onclick="resetForm()" class="mt-8 text-blue-600 underline text-sm font-bold hover:text-blue-800 transition">Send another message</button>
                </div>
            </div>
        </section>

    </main>

    <div id="eligibility-modal" class="modal-overlay">
        <div class="modal-content">
            <button onclick="closeEligibilityModal()" class="absolute top-4 right-4 text-gray-500 hover:text-red-500"><i data-feather="x"></i></button>
            <h3 class="text-xl font-bold mb-4 text-blue-900" data-key="elig_title">Eligibility Check</h3>
            <form action="https://api.web3forms.com/submit" method="POST">
                <input type="hidden" name="access_key" value="<?php echo $web3FormsKey; ?>">
                <input type="hidden" name="subject" value="Eligibility Check - Casandra">
                
                <div class="space-y-4">
                    <div><label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q1">1. City / Town</label><input type="text" name="city" class="input-standard" required></div>
                    <div><label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q2">2. Residency Status</label><select name="residency" class="input-standard"><option value="Pre-settle">Pre-settle</option><option value="Settle">Settle</option><option value="Citizen">British Citizen</option></select></div>
                    <div><label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q3">3. English Level</label><select name="english_level" class="input-standard"><option value="Basic">Basic</option><option value="Medium">Medium</option><option value="Advanced">Advanced</option></select></div>
                    <div><label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q4">4. Diploma</label><input type="text" name="diploma" class="input-standard" placeholder="Yes/No"></div>
                    <div><label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q5">5. Course Type</label><select name="course_type" class="input-standard"><option value="Undergraduate">Undergraduate</option><option value="Master">Master</option></select></div>
                    <div><label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q6">6. Field of Study</label><input type="text" name="field" class="input-standard" required></div>
                    <div><label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q7">7. Schedule</label><select name="schedule" class="input-standard"><option>2 Days</option><option>Evening</option><option>Weekend</option></select></div>
                    <div><label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q8">8. London?</label><select name="london" class="input-standard"><option>Yes</option><option>No</option></select></div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold" data-key="btn_submit_elig">Submit Answers</button>
                </div>
            </form>
        </div>
    </div>

    <footer class="bg-white text-gray-700 py-12 text-center mt-12 border-t border-gray-200">
        <div class="flex justify-center gap-4 mb-8 footer-socials">
            <a href="https://www.facebook.com/kss.andra.77" target="_blank" class="group transition transform hover:scale-110">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="#1877F2"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            </a>
            <a href="https://www.linkedin.com/in/casandra-banu" target="_blank" class="group transition transform hover:scale-110">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="#0A66C2"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
            </a>
            <a href="https://wa.me/447470788942" target="_blank" class="group transition transform hover:scale-110">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="#25D366"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
            </a>
            <a href="https://www.tiktok.com/@cassandra.ask33" target="_blank" class="group transition transform hover:scale-110">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="black" xmlns="http://www.w3.org/2000/svg" style="background:white; border-radius:50%; padding:4px;">
                    <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                </svg>
            </a>
        </div>

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

        const coursesDB = <?php echo $coursesJson ?: "[]"; ?>;
        const phpErrors = <?php echo $phpErrorsJson ?: "[]"; ?>;
        
        if (phpErrors.length > 0) console.error(phpErrors);

        function toggleMobileMenu() { document.getElementById('mobile-menu').classList.toggle('active'); }
        function openEligibilityModal() { document.getElementById('eligibility-modal').style.display = 'flex'; }
        function closeEligibilityModal() { document.getElementById('eligibility-modal').style.display = 'none'; }
        window.onclick = function(event) { if(event.target == document.getElementById('eligibility-modal')) closeEligibilityModal(); }

        let allSortedResults = [];
        let currentPage = 1;
        const resultsPerPage = 5;

        async function handleSearch(e) {
            e.preventDefault();
            
            const postcode = document.getElementById('user-postcode').value.trim().toLowerCase();
            const userLevel = document.getElementById('user-level').value;
            const userSubject = document.getElementById('user-subject').value;
            
            const div = document.getElementById('results-area');
            const spinner = document.getElementById('loading-spinner');
            const pagControls = document.getElementById('pagination-controls');

            if(!postcode) return alert("Please enter a City.");

            div.innerHTML = '';
            spinner.classList.remove('hidden');
            if(pagControls) pagControls.classList.add('hidden');
            allSortedResults = []; 

            // Simulate search delay
            setTimeout(() => {
                allSortedResults = coursesDB.filter(course => {
                    const courseCity = (course.city || "").toLowerCase();
                    const courseAddress = (course.address || "").toLowerCase();
                    const isLocationMatch = courseCity.includes(postcode) || courseAddress.includes(postcode);

                    const dbLevel = (course.level || "").toLowerCase();
                    const selLevel = userLevel.toLowerCase();
                    const isLevelMatch = (userLevel === 'All') || 
                                         (dbLevel.includes(selLevel)) || 
                                         (selLevel === "year 1" && dbLevel.includes("level 4"));

                    const isSubjectMatch = (userSubject === 'All') || (course.subject === userSubject);

                    return isLocationMatch && isLevelMatch && isSubjectMatch;
                });

                spinner.classList.add('hidden');
                
                if (allSortedResults.length > 0) {
                    currentPage = 1;
                    renderPage(1);
                } else {
                    div.innerHTML = '<div class="p-6 bg-white border border-gray-200 rounded-xl text-center text-gray-500">No courses found matching your criteria.</div>';
                }
            }, 600);
        }

        function renderPage(page) {
            const div = document.getElementById('results-area');
            const pagControls = document.getElementById('pagination-controls');
            const indicator = document.getElementById('page-indicator');
            
            div.innerHTML = '';
            
            const start = (page - 1) * resultsPerPage;
            const end = start + resultsPerPage;
            const pageItems = allSortedResults.slice(start, end);

            pageItems.forEach(c => {
                 const courseTitle = c.title || c.courses[0] || "Course";
                 const safeTitle = courseTitle.replace(/'/g, "\\'");

                 div.innerHTML += `
                <div class="bg-white p-6 rounded-xl border border-slate-100 mb-4 shadow-sm hover:shadow-md transition duration-300 group">
                    <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-[10px] font-bold text-white bg-[#1e3a8a] px-2 py-1 rounded-full uppercase tracking-wide">
                                    Accredited Course
                                </span>
                                 <span class="text-[10px] font-bold text-[#1e3a8a] bg-blue-50 px-2 py-1 rounded-full border border-blue-100">
                                    ${c.level || 'Degree'}
                                </span>
                            </div>
                            <h4 class="font-bold text-lg text-slate-800 group-hover:text-[#1e3a8a] transition">${courseTitle}</h4>
                            
                            <div class="text-xs text-slate-500 mt-3 flex flex-wrap gap-4">
                                <span class="flex items-center gap-1.5"><i data-feather="map-pin" class="w-3 h-3 text-red-500"></i> ${c.city || 'Campus'}</span>
                                <span class="flex items-center gap-1.5"><i data-feather="book-open" class="w-3 h-3 text-blue-500"></i> ${c.subject || 'General'}</span>
                            </div>
                        </div>
                        
                        <div class="text-right sm:text-right w-full sm:w-auto flex flex-row sm:flex-col items-center sm:items-end justify-between border-t sm:border-0 pt-3 sm:pt-0 border-slate-100 mt-2 sm:mt-0">
                            <div class="mb-0 sm:mb-3 text-left sm:text-right">
                                <span class="block text-lg font-bold text-emerald-600">Available</span>
                            </div>
                            <a href="#contact" onclick="document.querySelector('textarea[name=\\'message\\']').value = 'I am interested in applying for: ${safeTitle} (${c.level}). Please contact me details.';" class="btn-blue text-xs px-6 py-2 shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5">Apply Now</a>
                        </div>
                    </div>
                </div>`;
            });

            if (pagControls) {
                if (allSortedResults.length > resultsPerPage) {
                    pagControls.classList.remove('hidden');
                    indicator.innerText = `Page ${page} of ${Math.ceil(allSortedResults.length / resultsPerPage)}`;
                } else {
                    pagControls.classList.add('hidden');
                }
            }
            feather.replace();
        }

        function changePage(dir) {
            const totalPages = Math.ceil(allSortedResults.length / resultsPerPage);
            const newPage = currentPage + dir;
            if (newPage > 0 && newPage <= totalPages) {
                currentPage = newPage;
                renderPage(currentPage);
                document.getElementById('course-search').scrollIntoView({ behavior: 'smooth' });
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById('casandra-contact-form');
            const formWrapper = document.getElementById('contact-form-wrapper');
            const successMessage = document.getElementById('success-message');
            const submitBtn = document.getElementById('submit-btn');
            const btnText = document.getElementById('btn-text');
            const btnIcon = document.getElementById('btn-icon');
            const btnSpinner = document.getElementById('btn-spinner');

            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); 
                    submitBtn.disabled = true;
                    btnText.textContent = "Sending...";
                    btnIcon.classList.add('hidden');
                    btnSpinner.classList.remove('hidden');

                    const formData = new FormData(form);
                    formData.delete("botcheck"); 
                    const originalMessage = formData.get("message");
                    formData.set("message", originalMessage + "\n\n[Reference ID: " + Date.now() + "]");

                    fetch("https://api.web3forms.com/submit", {
                        method: "POST",
                        body: formData
                    })
                    .then(async (response) => {
                        const json = await response.json();
                        if (response.status === 200) {
                            formWrapper.style.opacity = '0';
                            formWrapper.style.transform = 'translateY(-20px)';
                            setTimeout(() => {
                                formWrapper.classList.add('hidden');
                                successMessage.classList.remove('pointer-events-none');
                                successMessage.classList.remove('translate-y-10'); 
                                successMessage.style.opacity = '1';
                                if (typeof feather !== 'undefined') feather.replace();
                            }, 500);
                        } else {
                            console.log(response);
                            if(json.message.includes("spam")) {
                                alert("System Message: Please wait 1 minute before sending another message.");
                            } else {
                                alert(json.message);
                            }
                            resetBtnState();
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        alert("Network error. Please check your connection.");
                        resetBtnState();
                    });
                });
            }

            function resetBtnState() {
                submitBtn.disabled = false;
                btnText.textContent = "Send Message";
                btnIcon.classList.remove('hidden');
                btnSpinner.classList.add('hidden');
            }

            window.resetForm = function() {
                form.reset();
                resetBtnState();
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
            };
        });

  

    const translations = {
        en: {
            nav_courses: "Courses", nav_about: "About", nav_join: "Join Team", nav_ai: "AI Tool", nav_contact: "Contact", 
            nav_tagline: "We help you find the right direction",
            
            role: "Team Leader & Educational Consultant", 
            hero_slogan: "\"Unlock your academic success with expert guidance.\"",
            btn_student: "Start Studying", btn_join: "Join My Team",

            search_title: "Search Accredited Courses", 
            lbl_postcode: "City", lbl_level: "Level", lbl_subject: "Subject", btn_find: "Find Course",

     about_sub: "Proven expertise, guaranteed results.",
bio_p1: "I am Casandra Banu, Team Leader and Educational Consultant at Ask33, an agency dedicated to supporting students who wish to start or continue their university studies in the UK. With a firm and well-structured approach, I offer A-to-Z consulting and guidance in the university admission process across the most prestigious cities in the UK, including London, Newcastle, Nottingham, Manchester, Leeds, and Birmingham.",
bio_quote: "\"With considerable experience in counseling students applying based on diplomas or work experience, I have helped numerous individuals choose their ideal academic path, successfully navigate admission requirements, and secure a place at top UK universities.\"",
bio_p2: "I understand that time and flexibility are essential. That's why I offer you the opportunity to study in a format that fits your schedule: online, on-campus, daytime, evening, or weekend. You can even choose to study just two days a week, allowing you to balance your personal and professional life without compromises. Choose success! Don't leave your education to chance. Contact me today and start your journey toward a successful university future!",

            why_title: "Why Work With Me?",
            why_1: "Professional approach", why_2: "Real field experience", why_3: "Clear communication", why_4: "Constant support", why_5: "Free & transparent process",

            ben_title: "Benefits for Students",
            ben_text: "Eligible students can benefit from: tuition fee coverage, maintenance financial support, public transport discounts, and stability throughout their studies.",

            services_title: "What I Offer",
            svc_1: "Free consultation", svc_2: "Process application", svc_3: "Document check", svc_4: "Application submission", 
            svc_5: "Interview preparation", svc_6: "English test preparation", svc_7: "Enrollment support", svc_8: "Student finance guidance",

            rec_title: "Join Ask33 Team – Student Advisor (Remote)", 
            rec_desc: "In my role as Team Leader at Ask33, I am expanding my team and looking for involved, persistent, and motivated people to work as Student Advisors, 100% remotely.",
            rec_ben_1: "High Earnings", rec_ben_1_d: "Up to £1,200 per student.",
            rec_ben_2: "100% Remote", rec_ben_2_d: "Work from home, flexible hours.",
            rec_ben_3: "Full Training", rec_ben_3_d: "Clear structure & continuous support.",
            rec_req: "You need: Laptop, communication skills, motivation.",
            btn_view_job: "Apply Now (Limited Spots)",

            ai_title: "AI Study Assistant", ai_sub: "Upload notes (PDF/DOCX) to generate summaries.", 
            ai_input_title: "1. Input Content", btn_upload: "Upload File", ai_btn: "Generate Materials", ai_output_title: "AI Result",

            prep_title: "Interview Preparation", prep_sub: "Master the skills needed for your university interview.",
            star_t: "STAR Method", star_d: "Master behavioral questions.",
            psych_t: "Ability assessment", psych_d: "Logic & reasoning practice.",
            case_t: "Case Studies", case_d: "Real-world scenarios.",

            elig_title: "Check Your Eligibility", elig_desc: "Answer a few questions to see if you qualify for Student Finance.", btn_check_elig: "Answer Questions",
            
            test_title: "Validate Your English Proficiency", test_desc: "A certified English level is often required. Take the official Duolingo English Test online.", btn_test: "Take Duolingo English Test",

            contact_title: "Contact Me", contact_sub: "Direct contact for residency & eligibility queries.", 
            lbl_name: "Full Name", lbl_phone: "Phone Number", lbl_email: "Email Address", lbl_msg: "How can I help?", btn_send: "Send Request",

            // Modal
            lbl_q1: "City", lbl_q2: "Residency Status", lbl_q3: "English Level", lbl_q4: "Diploma", lbl_q5: "Course Type", lbl_q6: "Field of Study", lbl_q7: "Preferred Schedule", lbl_q8: "Willing to study in London?", btn_submit_elig: "Submit Answers"
        },

        ro: {
            nav_courses: "Cursuri", nav_about: "Despre", nav_join: "Carieră", nav_ai: "Unealtă AI", nav_contact: "Contact", 
            nav_tagline: "Te ajutăm să găsești direcția potrivită",
            
            role: "Team Leader & Consilier Educațional", 
            hero_slogan: "\"Deblochează succesul academic cu ghidare expertă.\"",
            btn_student: "Vreau la Facultate", btn_join: "Alătură-te Echipei",

            search_title: "Caută Cursuri Acreditate", 
            lbl_postcode: "Oraș", lbl_level: "Nivel", lbl_subject: "Domeniu", btn_find: "Caută Curs",

           about_sub: "Expertiză dovedită, rezultate garantate.",
bio_p1: "Sunt Casandra Banu, Team Leader și Consilier Educațional la Ask33, o agenție dedicată sprijinirii studenților care doresc să înceapă sau să își continue studiile universitare în Marea Britanie. Cu o abordare fermă și bine structurată, ofer consultanță și îndrumare de la A la Z în procesul de admitere la universități din cele mai prestigioase orașe ale Regatului Unit, inclusiv Londra, Newcastle, Nottingham, Manchester, Leeds și Birmingham.",
bio_quote: "\"Cu o experiență considerabilă în consilierea studenților, atât pe baza diplomelor, cât și a experienței de muncă, am ajutat numeroase persoane să își aleagă calea academică ideală, să navigheze cu succes prin cerințele de admitere și să își asigure un loc în cadrul celor mai bune universități din Marea Britanie.\"",
bio_p2: "Înțeleg că timpul și flexibilitatea sunt esențiale. De aceea, îți ofer posibilitatea de a studia într-un format care se potrivește programului tău: online, în campus, zi, seară sau weekend. În plus, poți alege să studiezi doar două zile pe săptămână, astfel încât să îți poți organiza viața personală și profesională fără compromisuri. Alege succesul! Îți ofer consultanță de înaltă calitate, ghidaj personalizat și toate resursele necesare pentru a-ți transforma visele academice în realitate. Contactează-mă astăzi și începe-ți călătoria către un viitor universitar de succes!",
            why_title: "De ce să lucrezi cu mine?",
            why_1: "Abordare profesionistă", why_2: "Experiență reală", why_3: "Comunicare clară", why_4: "Suport constant", why_5: "Proces gratuit",

            ben_title: "Beneficii pentru studenți",
            ben_text: "Studenții eligibili pot beneficia de: acoperirea taxei de școlarizare, sprijin financiar pentru întreținere (£15k+), reduceri la transport și stabilitate.",

            services_title: "Ce ofer",
            svc_1: "Consultanță gratuită", svc_2: "Procesare dosar", svc_3: "Verificare acte", svc_4: "Trimitere aplicație", 
            svc_5: "Pregătire interviu", svc_6: "Pregătire test engleză", svc_7: "Suport înscriere", svc_8: "Ghidare Student Finance",

            rec_title: "Alătură-te echipei Ask33 – Student Advisor (Remote)", 
            rec_desc: "Îmi extind echipa și caut persoane implicate, perseverente și motivate pentru a lucra ca Student Advisor, 100% remote.",
            rec_ben_1: "Câștiguri Mari", rec_ben_1_d: "Până la £1,200 per student.",
            rec_ben_2: "100% Remote", rec_ben_2_d: "Lucrezi de acasă.",
            rec_ben_3: "Training Complet", rec_ben_3_d: "Structură clară și suport.",
            rec_req: "Ai nevoie de: Laptop, comunicare, motivație.",
            btn_view_job: "Aplică Acum",

            ai_title: "Asistent Studiu AI", ai_sub: "Încarcă notițe pentru a genera rezumate.", 
            ai_input_title: "1. Introdu Conținut", btn_upload: "Încarcă Fișier", ai_btn: "Generează Materiale", ai_output_title: "Rezultat AI",

            prep_title: "Pregătire Interviu", prep_sub: "Stăpânește abilitățile necesare pentru interviu.",
            star_t: "Metoda STAR", star_d: "Întrebări comportamentale.",
            psych_t: "Teste Abilități", psych_d: "Logică și raționament.",
            case_t: "Studii de Caz", case_d: "Scenarii reale.",

            elig_title: "Verifică Eligibilitatea", elig_desc: "Răspunde la câteva întrebări pentru a vedea dacă te califici.", btn_check_elig: "Răspunde la Întrebări",
            
            test_title: "Validează Nivelul de Engleză", test_desc: "Un nivel certificat este adesea necesar. Fă testul Duolingo online.", btn_test: "Fă Testul Duolingo",

            contact_title: "Contactează-mă", contact_sub: "Contact direct pentru rezidență și eligibilitate.", 
            lbl_name: "Nume Complet", lbl_phone: "Număr Telefon", lbl_email: "Adresă Email", lbl_msg: "Cum te pot ajuta?", btn_send: "Trimite Cerere",

            lbl_q1: "Oraș", lbl_q2: "Statut Rezidență", lbl_q3: "Nivel Engleză", lbl_q4: "Diplomă", lbl_q5: "Tip Curs", lbl_q6: "Domeniu", lbl_q7: "Program Preferat", lbl_q8: "Dorești în Londra?", btn_submit_elig: "Trimite Răspunsuri"
        },

        pl: {
            nav_courses: "Kursy", nav_about: "O mnie", nav_join: "Kariera", nav_ai: "Narzędzie AI", nav_contact: "Kontakt", 
            nav_tagline: "Pomożemy Ci znaleźć właściwy kierunek",
            role: "Lider Zespołu i Konsultant Edukacyjny", 
            hero_slogan: "\"Odblokuj swój sukces akademicki dzięki wsparciu eksperta.\"",
            btn_student: "Zacznij Studia", btn_join: "Dołącz do Zespołu",
            search_title: "Szukaj Akredytowanych Kursów", 
            lbl_postcode: "Miasto", lbl_level: "Poziom", lbl_subject: "Kierunek", btn_find: "Szukaj Kursu",
            about_sub: "Udowodnione doświadczenie, gwarantowane wyniki.",
bio_p1: "Jestem Casandra Banu, Lider Zespołu i Konsultant ds. Edukacji w Ask33, agencji wspierającej studentów pragnących rozpocząć lub kontynuować studia w Wielkiej Brytanii. Dzięki zorganizowanemu podejściu oferuję kompleksowe doradztwo w procesie rekrutacji na uniwersytety w prestiżowych miastach, takich jak Londyn, Newcastle, Nottingham, Manchester, Leeds i Birmingham.",
bio_quote: "\"Dzięki dużemu doświadczeniu w doradzaniu studentom aplikującym na podstawie dyplomów lub doświadczenia zawodowego, pomogłam wielu osobom wybrać idealną ścieżkę akademicką, przejść przez proces rekrutacji i zdobyć miejsce na najlepszych uczelniach w UK.\"",
bio_p2: "Rozumiem, że czas i elastyczność są kluczowe. Dlatego oferuję możliwość nauki w formacie dopasowanym do Twojego harmonogramu: online, na kampusie, w dzień, wieczorem lub w weekend. Możesz studiować tylko dwa dni w tygodniu, aby bez kompromisów łączyć życie osobiste z zawodowym. Wybierz sukces! Nie pozostawiaj swojej edukacji przypadkowi. Skontaktuj się ze mną już dziś i rozpocznij swoją drogę do udanej przyszłości akademickiej!",
            why_title: "Dlaczego ja?",
            why_1: "Profesjonalizm", why_2: "Doświadczenie", why_3: "Jasna komunikacja", why_4: "Stałe wsparcie", why_5: "Darmowy proces",
            ben_title: "Korzyści dla studentów", ben_text: "Pokrycie czesnego, wsparcie finansowe (£15k+), zniżki na transport.",
            services_title: "Co Oferuję", svc_1: "Darmowa konsultacja", svc_2: "Proces aplikacji", svc_3: "Sprawdzenie dokumentów", svc_4: "Wysłanie aplikacji", svc_5: "Przygotowanie do rozmowy", svc_6: "Test angielskiego", svc_7: "Wsparcie przy zapisach", svc_8: "Finanse studenckie",
            rec_title: "Dołącz do Ask33 – Doradca Studenta (Zdalnie)", rec_desc: "Szukam zaangażowanych osób do pracy zdalnej.",
            rec_ben_1: "Wysokie Zarobki", rec_ben_1_d: "Do £1,200 za studenta.", rec_ben_2: "100% Zdalnie", rec_ben_2_d: "Praca z domu.", rec_ben_3: "Szkolenie", rec_ben_3_d: "Pełne wsparcie.", rec_req: "Wymagane: Laptop, komunikatywność.", btn_view_job: "Aplikuj Teraz",
            ai_title: "Asystent AI", ai_sub: "Prześlij notatki.", ai_input_title: "1. Treść", btn_upload: "Prześlij Plik", ai_btn: "Generuj", ai_output_title: "Wynik",
            prep_title: "Przygotowanie do Rozmowy", prep_sub: "Opanuj umiejętności.", star_t: "Metoda STAR", star_d: "Pytania behawioralne.", psych_t: "Testy Zdolności", psych_d: "Logika.", case_t: "Studia Przypadku", case_d: "Scenariusze.",
            elig_title: "Sprawdź Kwalifikowalność", elig_desc: "Odpowiedz na pytania.", btn_check_elig: "Odpowiedz",
            test_title: "Sprawdź Angielski", test_desc: "Zrób test Duolingo online.", btn_test: "Zrób Test",
            contact_title: "Kontakt", contact_sub: "Pytania o rezydenturę i finanse.", lbl_name: "Imię i Nazwisko", lbl_phone: "Telefon", lbl_email: "Email", lbl_msg: "Wiadomość", btn_send: "Wyślij",
            lbl_q1: "Miasto", lbl_q2: "Status", lbl_q3: "Angielski", lbl_q4: "Dyplom", lbl_q5: "Typ Kursu", lbl_q6: "Kierunek", lbl_q7: "Harmonogram", lbl_q8: "Londyn?", btn_submit_elig: "Wyślij"
        },

        hu: {
            nav_courses: "Tanfolyamok", nav_about: "Rólam", nav_join: "Karrier", nav_ai: "AI Eszköz", nav_contact: "Kapcsolat", 
            nav_tagline: "Segítünk megtalálni a helyes irányt",
            role: "Csapatvezető és Oktatási Tanácsadó", hero_slogan: "\"Érd el sikereidet szakértői útmutatással.\"",
            btn_student: "Tanulás Kezdése", btn_join: "Csatlakozz",
            search_title: "Keresés", lbl_postcode: "Város", lbl_level: "Szint", lbl_subject: "Tárgy", btn_find: "Keresés",
           about_sub: "Bizonyított szakértelem, garantált eredmények.",
bio_p1: "Casandra Banu vagyok, az Ask33 csapatvezetője és oktatási tanácsadója. Egy olyan ügynökséget képviselek, amely az Egyesült Királyságban tanulni vágyó diákokat támogatja. Határozott és jól felépített megközelítéssel A-tól Z-ig terjedő tanácsadást nyújtok a felvételi folyamatban London, Newcastle, Nottingham, Manchester, Leeds és Birmingham legnevesebb egyetemein.",
bio_quote: "\"Jelentős tapasztalattal rendelkezem a diplomával vagy munkatapasztalattal jelentkező diákok tanácsadásában, és számos embernek segítettem az ideális tanulmányi út kiválasztásában, a felvételi követelmények sikeres teljesítésében és a bejutásban az Egyesült Királyság legjobb egyetemeire.\"",
bio_p2: "Megértem, hogy az idő és a rugalmasság elengedhetetlen. Ezért kínálom Önnek a lehetőséget, hogy olyan formában tanuljon, ami illik az idejéhez: online, az egyetemen, nappal, este vagy hétvégén. Akár heti két napos beosztást is választhat, hogy kompromisszumok nélkül szervezhesse magán- és szakmai életét. Válassza a sikert! Lépjen kapcsolatba velem még ma, és kezdje meg az útját egy sikeres egyetemi jövő felé!",
            why_title: "Miért én?", why_1: "Professzionalizmus", why_2: "Tapasztalat", why_3: "Kommunikáció", why_4: "Támogatás", why_5: "Ingyenes",
            ben_title: "Előnyök", ben_text: "Tandíjfedezet, megélhetési támogatás, utazási kedvezmények.",
            services_title: "Amit Kínálok", svc_1: "Ingyenes konzultáció", svc_2: "Jelentkezés", svc_3: "Dokumentumok", svc_4: "Benyújtás", svc_5: "Interjú felkészítés", svc_6: "Angol teszt", svc_7: "Beiratkozás", svc_8: "Pénzügyi tanács",
            rec_title: "Csatlakozz – Diáktanácsadó (Remote)", rec_desc: "Motivált embereket keresek távmunkára.",
            rec_ben_1: "Magas Kereset", rec_ben_1_d: "£1,200/diák.", rec_ben_2: "Távmunka", rec_ben_2_d: "Otthonról.", rec_ben_3: "Képzés", rec_ben_3_d: "Támogatás.", rec_req: "Laptop, motiváció.", btn_view_job: "Jelentkezz",
            ai_title: "AI Asszisztens", ai_sub: "Jegyzetek feltöltése.", ai_input_title: "1. Tartalom", btn_upload: "Fájl", ai_btn: "Generálás", ai_output_title: "Eredmény",
            prep_title: "Interjú", prep_sub: "Felkészülés.", star_t: "STAR Módszer", star_d: "Viselkedés.", psych_t: "Képesség", psych_d: "Logika.", case_t: "Esettanulmány", case_d: "Valós példák.",
            elig_title: "Jogosultság", elig_desc: "Válaszolj kérdésekre.", btn_check_elig: "Válaszadás",
            test_title: "Angol Teszt", test_desc: "Duolingo online.", btn_test: "Teszt Indítása",
            contact_title: "Kapcsolat", contact_sub: "Írj nekem.", lbl_name: "Név", lbl_phone: "Telefon", lbl_email: "Email", lbl_msg: "Üzenet", btn_send: "Küldés",
            lbl_q1: "Város", lbl_q2: "Státusz", lbl_q3: "Angol", lbl_q4: "Diploma", lbl_q5: "Típus", lbl_q6: "Terület", lbl_q7: "Ütemezés", lbl_q8: "London?", btn_submit_elig: "Küldés"
        },

        es: {
            nav_courses: "Cursos", nav_about: "Sobre Mí", nav_join: "Equipo", nav_ai: "IA", nav_contact: "Contacto", 
            nav_tagline: "Te ayudamos a encontrar el camino correcto",
            role: "Líder de Equipo y Consultora Educativa", hero_slogan: "\"Desbloquea tu éxito académico con guía experta.\"",
            btn_student: "Empezar", btn_join: "Únete al Equipo",
            search_title: "Buscar Cursos", lbl_postcode: "Ciudad", lbl_level: "Nivel", lbl_subject: "Tema", btn_find: "Buscar",
            about_sub: "Experiencia probada, resultados garantizados.",
bio_p1: "Soy Casandra Banu, Líder de Equipo y Consultora Educativa en Ask33, una agencia dedicada a apoyar a estudiantes que desean iniciar o continuar sus estudios universitarios en el Reino Unido. Con un enfoque firme y bien estructurado, ofrezco asesoramiento integral de la A a la Z en el proceso de admisión a universidades en ciudades como Londres, Newcastle, Nottingham, Manchester, Leeds y Birmingham.",
bio_quote: "\"Con considerable experiencia asesorando a estudiantes que aplican en base a diplomas o experiencia laboral, he ayudado a numerosas personas a elegir su camino académico ideal, superar con éxito los requisitos de admisión y asegurar su lugar en las mejores universidades del Reino Unido.\"",
bio_p2: "Entiendo que el tiempo y la flexibilidad son esenciales. Por eso te ofrezco la posibilidad de estudiar en un formato que se adapte a tu horario: online, en el campus, de día, de noche o en fin de semana. Incluso puedes elegir estudiar solo dos días a la semana, para organizar tu vida personal y profesional sin compromisos. ¡Elige el éxito! Contáctame hoy y comienza tu camino hacia un futuro universitario exitoso.",
            why_title: "¿Por qué yo?", why_1: "Profesionalismo", why_2: "Experiencia real", why_3: "Comunicación", why_4: "Apoyo constante", why_5: "Gratuito",
            ben_title: "Beneficios", ben_text: "Matrícula cubierta, apoyo financiero (£15k+), descuentos.",
            services_title: "Lo que ofrezco", svc_1: "Consulta gratis", svc_2: "Procesar solicitud", svc_3: "Revisar docs", svc_4: "Enviar solicitud", svc_5: "Prep. entrevista", svc_6: "Prep. inglés", svc_7: "Inscripción", svc_8: "Finanzas",
            rec_title: "Únete a Ask33 – Asesor (Remoto)", rec_desc: "Busco personas motivadas para trabajar desde casa.",
            rec_ben_1: "Altos Ingresos", rec_ben_1_d: "Hasta £1,200/estudiante.", rec_ben_2: "100% Remoto", rec_ben_2_d: "Desde casa.", rec_ben_3: "Entrenamiento", rec_ben_3_d: "Soporte total.", rec_req: "Laptop, motivación.", btn_view_job: "Aplica Ya",
            ai_title: "Asistente IA", ai_sub: "Sube notas.", ai_input_title: "1. Contenido", btn_upload: "Subir", ai_btn: "Generar", ai_output_title: "Resultado",
            prep_title: "Entrevista", prep_sub: "Domina las habilidades.", star_t: "Método STAR", star_d: "Comportamiento.", psych_t: "Habilidad", psych_d: "Lógica.", case_t: "Casos", case_d: "Escenarios.",
            elig_title: "Elegibilidad", elig_desc: "Responde preguntas.", btn_check_elig: "Responder",
            test_title: "Prueba Inglés", test_desc: "Duolingo online.", btn_test: "Tomar Test",
            contact_title: "Contacto", contact_sub: "Consultas directas.", lbl_name: "Nombre", lbl_phone: "Teléfono", lbl_email: "Email", lbl_msg: "Mensaje", btn_send: "Enviar",
            lbl_q1: "Ciudad", lbl_q2: "Residencia", lbl_q3: "Inglés", lbl_q4: "Diploma", lbl_q5: "Tipo", lbl_q6: "Campo", lbl_q7: "Horario", lbl_q8: "¿Londres?", btn_submit_elig: "Enviar"
        },

        it: {
            nav_courses: "Corsi", nav_about: "Chi Sono", nav_join: "Lavora con noi", nav_ai: "Strumento IA", nav_contact: "Contatti", 
            nav_tagline: "Ti aiutiamo a trovare la strada giusta",
            role: "Team Leader & Consulente Educativo", hero_slogan: "\"Sblocca il tuo successo accademico.\"",
            btn_student: "Inizia", btn_join: "Unisciti",
            search_title: "Cerca Corsi", lbl_postcode: "Città", lbl_level: "Livello", lbl_subject: "Materia", btn_find: "Cerca",
            about_sub: "Esperienza comprovata, risultati garantiti.",
bio_p1: "Sono Casandra Banu, Team Leader e Consulente Educativo presso Ask33, un'agenzia dedicata a supportare gli studenti che desiderano iniziare o continuare i loro studi universitari nel Regno Unito. Con un approccio ben strutturato, offro consulenza a 360 gradi nel processo di ammissione presso le università di Londra, Newcastle, Nottingham, Manchester, Leeds e Birmingham.",
bio_quote: "\"Con una notevole esperienza nella consulenza a studenti che si iscrivono tramite diplomi o esperienza lavorativa, ho aiutato numerose persone a scegliere il loro percorso accademico ideale e ad assicurarsi un posto nelle migliori università britanniche.\"",
bio_p2: "Capisco che il tempo e la flessibilità sono essenziali. Ecco perché ti offro la possibilità di studiare in un formato adatto al tuo programma: online, nel campus, di giorno, di sera o nel fine settimana. Puoi persino scegliere di studiare solo due giorni a settimana, per bilanciare la tua vita personale e professionale. Scegli il successo! Contattami oggi e inizia il tuo viaggio verso un futuro accademico di successo!",
            why_title: "Perché io?", why_1: "Professionalità", why_2: "Esperienza", why_3: "Comunicazione", why_4: "Supporto", why_5: "Gratuito",
            ben_title: "Vantaggi", ben_text: "Tasse coperte, supporto finanziario, sconti.",
            services_title: "Cosa Offro", svc_1: "Consulenza gratuita", svc_2: "Gestione pratica", svc_3: "Controllo documenti", svc_4: "Invio domanda", svc_5: "Prep. colloquio", svc_6: "Test inglese", svc_7: "Iscrizione", svc_8: "Finanza studenti",
            rec_title: "Lavora con Ask33 (Remoto)", rec_desc: "Cerco persone motivate per lavorare da casa.",
            rec_ben_1: "Guadagni Alti", rec_ben_1_d: "Fino a £1,200/studente.", rec_ben_2: "Remoto", rec_ben_2_d: "Da casa.", rec_ben_3: "Formazione", rec_ben_3_d: "Supporto.", rec_req: "Laptop, motivazione.", btn_view_job: "Candidati",
            ai_title: "Assistente IA", ai_sub: "Carica appunti.", ai_input_title: "1. Contenuto", btn_upload: "Carica", ai_btn: "Genera", ai_output_title: "Risultato",
            prep_title: "Colloquio", prep_sub: "Preparazione.", star_t: "Metodo STAR", star_d: "Comportamento.", psych_t: "Abilità", psych_d: "Logica.", case_t: "Casi Studio", case_d: "Scenari.",
            elig_title: "Idoneità", elig_desc: "Verifica ora.", btn_check_elig: "Rispondi",
            test_title: "Test Inglese", test_desc: "Duolingo online.", btn_test: "Fai Test",
            contact_title: "Contatti", contact_sub: "Scrivimi.", lbl_name: "Nome", lbl_phone: "Telefono", lbl_email: "Email", lbl_msg: "Messaggio", btn_send: "Invia",
            lbl_q1: "Città", lbl_q2: "Residenza", lbl_q3: "Inglese", lbl_q4: "Diploma", lbl_q5: "Tipo", lbl_q6: "Campo", lbl_q7: "Orario", lbl_q8: "Londra?", btn_submit_elig: "Invia"
        },

        pt: {
            nav_courses: "Cursos", nav_about: "Sobre", nav_join: "Equipe", nav_ai: "IA", nav_contact: "Contato", 
            nav_tagline: "Ajudamos você a encontrar o caminho certo",
            role: "Líder de Equipe e Consultora", hero_slogan: "\"Desbloqueie seu sucesso acadêmico.\"",
            btn_student: "Começar", btn_join: "Junte-se",
            search_title: "Buscar Cursos", lbl_postcode: "Cidade", lbl_level: "Nível", lbl_subject: "Assunto", btn_find: "Buscar",
           about_sub: "Experiência comprovada, resultados garantidos.",
bio_p1: "Sou Casandra Banu, Líder de Equipe e Consultora Educacional na Ask33, uma agência dedicada a apoiar alunos que desejam iniciar ou continuar os seus estudos universitários no Reino Unido. Com uma abordagem estruturada, ofereço consultoria completa de A a Z no processo de admissão em universidades de Londres, Newcastle, Nottingham, Manchester, Leeds e Birmingham.",
bio_quote: "\"Com considerável experiência no aconselhamento de estudantes que se candidatam com base em diplomas ou experiência de trabalho, ajudei inúmeras pessoas a escolher o caminho académico ideal, a cumprir os requisitos de admissão e a garantir um lugar nas melhores universidades do Reino Unido.\"",
bio_p2: "Entendo que tempo e flexibilidade são essenciais. É por isso que lhe ofereço a oportunidade de estudar num formato que se adapte ao seu horário: online, no campus, de dia, à noite ou ao fim de semana. Pode até escolher estudar apenas dois dias por semana, permitindo-lhe equilibrar a vida pessoal e profissional. Escolha o sucesso! Contacte-me hoje e comece a sua jornada rumo a um futuro universitário de sucesso!",
            why_title: "Por que eu?", why_1: "Profissionalismo", why_2: "Experiência", why_3: "Comunicação", why_4: "Apoio", why_5: "Gratuito",
            ben_title: "Benefícios", ben_text: "Propinas cobertas, apoio financeiro, descontos.",
            services_title: "O que ofereço", svc_1: "Consulta grátis", svc_2: "Processo", svc_3: "Documentos", svc_4: "Envio", svc_5: "Entrevista", svc_6: "Inglês", svc_7: "Matrícula", svc_8: "Finanças",
            rec_title: "Junte-se à Ask33 (Remoto)", rec_desc: "Procuro pessoas motivadas.",
            rec_ben_1: "Ganhos Altos", rec_ben_1_d: "Até £1,200/aluno.", rec_ben_2: "Remoto", rec_ben_2_d: "De casa.", rec_ben_3: "Treino", rec_ben_3_d: "Suporte.", rec_req: "Laptop, motivação.", btn_view_job: "Aplicar",
            ai_title: "Assistente IA", ai_sub: "Carregar notas.", ai_input_title: "1. Conteúdo", btn_upload: "Carregar", ai_btn: "Gerar", ai_output_title: "Resultado",
            prep_title: "Entrevista", prep_sub: "Preparação.", star_t: "Método STAR", star_d: "Comportamento.", psych_t: "Habilidade", psych_d: "Lógica.", case_t: "Casos", case_d: "Cenários.",
            elig_title: "Elegibilidade", elig_desc: "Verifique agora.", btn_check_elig: "Responder",
            test_title: "Teste Inglês", test_desc: "Duolingo online.", btn_test: "Fazer Teste",
            contact_title: "Contato", contact_sub: "Fale comigo.", lbl_name: "Nome", lbl_phone: "Telefone", lbl_email: "Email", lbl_msg: "Mensagem", btn_send: "Enviar",
            lbl_q1: "Cidade", lbl_q2: "Residência", lbl_q3: "Inglês", lbl_q4: "Diploma", lbl_q5: "Tipo", lbl_q6: "Área", lbl_q7: "Horário", lbl_q8: "Londres?", btn_submit_elig: "Enviar"
        },

        el: {
            nav_courses: "Μαθήματα", nav_about: "Σχετικά", nav_join: "Καριέρα", nav_ai: "Εργαλείο AI", nav_contact: "Επαφή", 
            nav_tagline: "Σας βοηθάμε να βρείτε τη σωστή κατεύθυνση",
            role: "Επικεφαλής Ομάδας & Σύμβουλος", hero_slogan: "\"Ξεκλειδώστε την επιτυχία σας.\"",
            btn_student: "Έναρξη", btn_join: "Γίνετε Μέλος",
            search_title: "Αναζήτηση", lbl_postcode: "Πόλη", lbl_level: "Επίπεδο", lbl_subject: "Θέμα", btn_find: "Εύρεση",
           about_sub: "Αποδεδειγμένη εμπειρία, εγγυημένα αποτελέσματα.",
bio_p1: "Είμαι η Casandra Banu, Επικεφαλής Ομάδας και Εκπαιδευτική Σύμβουλος στην Ask33, ένα πρακτορείο αφιερωμένο στην υποστήριξη φοιτητών που επιθυμούν να ξεκινήσουν ή να συνεχίσουν τις σπουδές τους στο Ηνωμένο Βασίλειο. Με μια δομημένη προσέγγιση, προσφέρω καθοδήγηση από το Α έως το Ω στη διαδικασία εισαγωγής σε πανεπιστήμια σε Λονδίνο, Νιούκαστλ, Νότιγχαμ, Μάντσεστερ, Λιντς και Μπέρμιγχαμ.",
bio_quote: "\"Με σημαντική εμπειρία στη συμβουλευτική φοιτητών που κάνουν αίτηση βάσει διπλωμάτων ή εργασιακής εμπειρίας, έχω βοηθήσει πολλά άτομα να επιλέξουν την ιδανική ακαδημαϊκή πορεία, να πλοηγηθούν επιτυχώς στις απαιτήσεις εισαγωγής και να εξασφαλίσουν μια θέση στα καλύτερα πανεπιστήμια του ΗΒ.\"",
bio_p2: "Κατανοώ ότι ο χρόνος και η ευελιξία είναι απαραίτητα. Προσφέρω την ευκαιρία να σπουδάσετε σε μορφή που ταιριάζει στο πρόγραμμά σας: online, στην πανεπιστημιούπολη, πρωί, βράδυ ή Σαββατοκύριακο. Μπορείτε να επιλέξετε να σπουδάζετε μόνο δύο ημέρες την εβδομάδα, χωρίς συμβιβασμούς. Επιλέξτε την επιτυχία! Επικοινωνήστε μαζί μου σήμερα και ξεκινήστε το ταξίδι σας για ένα επιτυχημένο πανεπιστημιακό μέλλον!",
            why_title: "Γιατί εγώ;", why_1: "Επαγγελματισμός", why_2: "Εμπειρία", why_3: "Επικοινωνία", why_4: "Υποστήριξη", why_5: "Δωρεάν",
            ben_title: "Οφέλη", ben_text: "Κάλυψη διδάκτρων, οικονομική στήριξη, εκπτώσεις.",
            services_title: "Υπηρεσίες", svc_1: "Δωρεάν συμβουλή", svc_2: "Αίτηση", svc_3: "Έλεγχος", svc_4: "Υποβολή", svc_5: "Συνέντευξη", svc_6: "Αγγλικά", svc_7: "Εγγραφή", svc_8: "Οικονομικά",
            rec_title: "Εργασία στην Ask33 (Remote)", rec_desc: "Ψάχνω άτομα με κίνητρα.",
            rec_ben_1: "Υψηλά Κέρδη", rec_ben_1_d: "£1,200/φοιτητή.", rec_ben_2: "Εξ αποστάσεως", rec_ben_2_d: "Από σπίτι.", rec_ben_3: "Εκπαίδευση", rec_ben_3_d: "Υποστήριξη.", rec_req: "Laptop, όρεξη.", btn_view_job: "Αίτηση",
            ai_title: "Βοηθός AI", ai_sub: "Ανέβασμα σημειώσεων.", ai_input_title: "1. Περιεχόμενο", btn_upload: "Αρχείο", ai_btn: "Δημιουργία", ai_output_title: "Αποτέλεσμα",
            prep_title: "Συνέντευξη", prep_sub: "Προετοιμασία.", star_t: "Μέθοδος STAR", star_d: "Συμπεριφορά.", psych_t: "Ικανότητες", psych_d: "Λογική.", case_t: "Μελέτες", case_d: "Σενάρια.",
            elig_title: "Επιλεξιμότητα", elig_desc: "Έλεγχος.", btn_check_elig: "Απάντηση",
            test_title: "Τεστ Αγγλικών", test_desc: "Duolingo online.", btn_test: "Έναρξη",
            contact_title: "Επαφή", contact_sub: "Στείλτε μήνυμα.", lbl_name: "Όνομα", lbl_phone: "Τηλέφωνο", lbl_email: "Email", lbl_msg: "Μήνυμα", btn_send: "Αποστολή",
            lbl_q1: "Πόλη", lbl_q2: "Καθεστώς", lbl_q3: "Αγγλικά", lbl_q4: "Δίπλωμα", lbl_q5: "Τύπος", lbl_q6: "Πεδίο", lbl_q7: "Πρόγραμμα", lbl_q8: "Λονδίνο;", btn_submit_elig: "Υποβολή"
        },

        bg: {
            nav_courses: "Курсове", nav_about: "За Мен", nav_join: "Кариера", nav_ai: "AI Инструмент", nav_contact: "Контакт", 
            nav_tagline: "Ние ви помагаме да намерите правилната посока",
            role: "Ръководител Екип и Консултант", hero_slogan: "\"Отключете успеха си с експертна помощ.\"",
            btn_student: "Започни", btn_join: "Присъедини се",
            search_title: "Търсене", lbl_postcode: "Град", lbl_level: "Ниво", lbl_subject: "Предмет", btn_find: "Търси",
           about_sub: "Доказан опит, гарантирани резултати.",
bio_p1: "Аз съм Касандра Бану, Ръководител на Екип и Образователен Консултант в Ask33, агенция, посветена на подкрепата на студенти, които искат да започнат или продължат обучението си в Обединеното кралство. Предлагам консултации от А до Я в процеса на прием в университети в Лондон, Нюкасъл, Нотингам, Манчестър, Лийдс и Бирмингам.",
bio_quote: "\"Със значителен опит в консултирането на студенти, кандидатстващи въз основа на дипломи или трудов стаж, съм помогнала на много хора да изберат идеалния си академичен път, да преминат успешно през изискванията за прием и да си осигурят място в най-добрите университети в Обединеното кралство.\"",
bio_p2: "Разбирам, че времето и гъвкавостта са от съществено значение. Затова ви предлагам възможност за обучение във формат, който отговаря на вашия график: онлайн, в кампуса, през деня, вечер или през уикенда. Можете дори да изберете да учите само два дни в седмицата. Изберете успеха! Свържете се с мен днес и започнете пътуването си към успешно академично бъдеще!",
            why_title: "Защо аз?", why_1: "Професионализъм", why_2: "Опит", why_3: "Комуникация", why_4: "Подкрепа", why_5: "Безплатно",
            ben_title: "Ползи", ben_text: "Покрити такси, финансова помощ, отстъпки.",
            services_title: "Услуги", svc_1: "Консултация", svc_2: "Обработка", svc_3: "Документи", svc_4: "Изпращане", svc_5: "Интервю", svc_6: "Английски", svc_7: "Записване", svc_8: "Финанси",
            rec_title: "Работа в Ask33 (Дистанционно)", rec_desc: "Търся мотивирани хора.",
            rec_ben_1: "Високи Доходи", rec_ben_1_d: "£1,200/студент.", rec_ben_2: "Дистанционно", rec_ben_2_d: "От вкъщи.", rec_ben_3: "Обучение", rec_ben_3_d: "Подкрепа.", rec_req: "Лаптоп, мотивация.", btn_view_job: "Кандидатствай",
            ai_title: "AI Асистент", ai_sub: "Качи записки.", ai_input_title: "1. Съдържание", btn_upload: "Файл", ai_btn: "Генерирай", ai_output_title: "Резултат",
            prep_title: "Интервю", prep_sub: "Подготовка.", star_t: "Метод STAR", star_d: "Поведение.", psych_t: "Умения", psych_d: "Логика.", case_t: "Казуси", case_d: "Сценарии.",
            elig_title: "Допустимост", elig_desc: "Проверка.", btn_check_elig: "Отговори",
            test_title: "Английски Тест", test_desc: "Duolingo онлайн.", btn_test: "Старт",
            contact_title: "Контакт", contact_sub: "Пишете ми.", lbl_name: "Име", lbl_phone: "Телефон", lbl_email: "Имейл", lbl_msg: "Съобщение", btn_send: "Изпрати",
            lbl_q1: "Град", lbl_q2: "Статут", lbl_q3: "Английски", lbl_q4: "Диплома", lbl_q5: "Тип", lbl_q6: "Сфера", lbl_q7: "График", lbl_q8: "Лондон?", btn_submit_elig: "Изпрати"
        }
    };


        function changeLanguage(lang) {
            const t = translations[lang] || translations['en'];
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
