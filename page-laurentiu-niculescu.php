<?php
/*
*/


if (!function_exists('get_template_directory_uri')) {
    function get_template_directory_uri() { return '.'; }
}
if (!function_exists('home_url')) {
    function home_url($path = '') { return '/' . ltrim($path, '/'); }
}

$baseDir = __DIR__;

$configFile = $baseDir . '/config.json';
$googleMapsKey = "";

if (file_exists($configFile)) {
    $configData = json_decode(file_get_contents($configFile), true);
    $googleMapsKey = $configData['googleMapsKey'] ?? "";
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laurentiu Niculescu | Student Advisor</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    
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
                <span class="text-sm font-medium text-gray-700">
        We help you find the right direction
    </span>

                <span class="text-[9px] font-bold text-blue-900 tracking-wide uppercase mt-0.5">
                    Powered by <span class="hover:text-red-600 active:text-red-700 transition-colors cursor-pointer" 
onclick="window.open('https://www.ask33.co.uk/', '_blank')">ASK 33</span>
                </span>
            </a>


            <div class="hidden md:flex gap-8 items-center font-medium text-gray-600">
                <a href="#course-search" class="hover:text-[#1e3a8a] transition" data-key="nav_courses">Courses</a>
                <a href="#eligibility" class="hover:text-[#1e3a8a] transition" data-key="nav_eligibility">Eligibility</a>
                
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
                
                <a href="#contact" class="btn-blue shadow-md" data-key="btn_contact">Contact</a>
            </div>

            <button class="md:hidden p-2 text-slate-600 border border-slate-300 rounded-lg hover:bg-slate-100 transition" onclick="toggleMobileMenu()">
                <i data-feather="menu"></i>
            </button>

            <div id="mobile-menu">
                <a href="#course-search" class="block py-2 font-medium text-gray-600 hover:text-[#1e3a8a]" data-key="nav_courses">Courses</a>
                <a href="#eligibility" class="block py-2 font-medium text-gray-600 hover:text-[#1e3a8a]" data-key="nav_eligibility">Eligibility</a>
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
                <a href="#contact" class="btn-blue w-full mt-4 text-center" data-key="btn_contact">Contact</a>
            </div>
        </div>
    </nav>
    
    <main>
        <section class="pt-40 pb-24 px-6 border-b border-gray-100/50">
            <div class="max-w-5xl mx-auto flex flex-col md:flex-row items-center gap-12 fade-in">
                <div class="relative shrink-0">
                    <div class="absolute inset-0 bg-[#1e3a8a] blur-xl opacity-20 rounded-full"></div>
                    <img src="<?php echo get_template_directory_uri(); ?>/images/LaurentiuNiculescu.jpg" alt="Laurentiu Niculescu" class="relative w-64 h-64 rounded-full border-4 border-white shadow-2xl object-cover">
                </div>
                <div class="text-center md:text-left">
                    <h1 class="text-5xl font-bold text-slate-900 mb-2 serif-font">Laurentiu Niculescu</h1>
                    <p class="font-bold tracking-widest uppercase mb-6" style="color: #ff7f7f;" data-key="role">Student Advisor & Academic Coach</p>
                    <p class="text-lg text-gray-600 mb-8 max-w-xl leading-relaxed italic" data-key="hero_slogan">"Guiding you through the academic maze with clarity and confidence."</p>
                    <div class="flex flex-wrap gap-4 justify-center md:justify-start">
                        <a href="#contact" class="btn-blue shadow-lg transition" data-key="btn_contact">Get in Touch</a>
                        <a href="<?php echo home_url('/#team'); ?>" class="btn-outline-blue" data-key="btn_back">Back to Team</a>
                    </div>
                </div>
            </div>
        </section>

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
        <section class="py-20 px-6">
            <div class="max-w-6xl mx-auto content-card">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-slate-900 serif-font" data-key="about_title">About Me</h2>
                    <p class="text-slate-500 mt-2" data-key="about_sub">My mission, passion, and a brief introduction.</p>
                </div>
                <div class="grid lg:grid-cols-2 gap-12">
                    <div class="space-y-6 text-gray-700 text-lg leading-relaxed">
                        <p data-key="bio_p1">I’m not here to throw academic jargon at you. I’m here to help you get into college—without the stress and confusion. My job is to guide you through the maze of applications, course choices, and personal statements.</p>
                        <div class="bg-[#eff6ff] p-6 rounded-xl border-l-4 border-[#1e3a8a] italic text-slate-800">
                            <p data-key="bio_quote">"My style is student-centered and fully committed to making your application stand out."</p>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-8 rounded-2xl border border-gray-200 h-fit shadow-sm">
                        <h4 class="font-bold text-xl text-[#1e3a8a] mb-6" data-key="values_title">Core Values</h4>
                        <ul class="space-y-4 text-gray-700">
                            <li class="flex items-center gap-3 bg-white p-3 rounded shadow-sm"><i data-feather="heart" class="text-[#ff7f7f]"></i> <span data-key="val_1">Empathy</span></li>
                            <li class="flex items-center gap-3 bg-white p-3 rounded shadow-sm"><i data-feather="check-circle" class="text-[#2563eb]"></i> <span data-key="val_2">Integrity</span></li>
                            <li class="flex items-center gap-3 bg-white p-3 rounded shadow-sm"><i data-feather="zap" class="text-amber-500"></i> <span data-key="val_3">Empowerment</span></li>
                        </ul>
                    </div>
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
                    <a href="<?php echo home_url('/prep-star/'); ?>" class="prep-card">
                        <i data-feather="star" class="w-10 h-10 text-amber-400 mb-4 mx-auto"></i>
                        <h3 class="text-xl font-bold mb-2" data-key="star_t">STAR Method</h3>
                        <p class="text-sm text-slate-600" data-key="star_d">Master behavioral questions.</p>
                    </a>
                    <a href="<?php echo home_url('/prep-psych/'); ?>" class="prep-card">
                        <i data-feather="cpu" class="w-10 h-10 text-blue-400 mb-4 mx-auto"></i>
                        <h3 class="text-xl font-bold mb-2" data-key="psych_t">Ability Assessment</h3>
                        <p class="text-sm text-slate-600" data-key="psych_d">Logic & reasoning practice.</p>
                    </a>
                    <a href="<?php echo home_url('/prep-case/'); ?>" class="prep-card">
                        <i data-feather="briefcase" class="w-10 h-10 text-purple-400 mb-4 mx-auto"></i>
                        <h3 class="text-xl font-bold mb-2" data-key="case_t">Case Studies</h3>
                        <p class="text-sm text-slate-600" data-key="case_d">Real-world scenarios.</p>
                    </a>
                </div>
            </div>
        </section>

        <section id="eligibility" class="py-12 px-6">
            <div class="max-w-4xl mx-auto content-card bg-[#eff6ff] border border-[#1e3a8a] text-center p-10">
                <i data-feather="check-square" class="w-12 h-12 text-[#1e3a8a] mx-auto mb-4"></i>
                <h2 class="text-2xl font-bold text-[#1e3a8a] mb-4" data-key="elig_title">Check Your Eligibility</h2>
                <p class="text-gray-600 mb-6" data-key="elig_desc">Answer a few questions to see if you qualify for Student Finance and admission.</p>
                <button onclick="openEligibilityModal()" class="btn-blue shadow-lg hover:-translate-y-1 transition" data-key="btn_check_elig">Answer Questions</button>
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
            <div class="max-w-xl mx-auto content-card relative overflow-hidden" style="min-height: 400px;">
                
                <div id="contact-form-wrapper" class="transition-all duration-500 ease-in-out">
                    <h2 class="text-2xl font-bold text-center text-slate-900 mb-4" data-key="form_header">Contact Me</h2>
                    <p class="text-center text-gray-500 mb-8" data-key="form_sub">Ready to start? Fill in the details below.</p>
                    
                    <form id="laurentiu-contact-form" action="https://api.web3forms.com/submit" method="POST" class="space-y-5">
                        <input type="hidden" name="access_key" value="<?php echo $web3FormsKey; ?>">
                        <input type="hidden" name="subject" value="New Contact for Laurentiu Niculescu">
                        <input type="hidden" name="from_name" value="One Guide Profile">

                        <input type="text" name="name" class="input-standard" data-key="lbl_name" placeholder="Full Name" required>
                        <input type="tel" name="phone" class="input-standard" data-key="lbl_phone" placeholder="Phone Number" required>
                        <input type="email" name="email" class="input-standard" data-key="lbl_email" placeholder="Email Address" required>
                        <textarea name="message" rows="4" class="input-standard" data-key="lbl_msg" placeholder="Message" required></textarea>
                        
                        <button type="submit" id="submit-btn" class="w-full btn-blue flex justify-center items-center gap-2">
                            <span id="btn-text" data-key="btn_send">Send Message</span>
                            <i id="btn-icon" data-feather="send" class="w-4 h-4"></i>
                            <svg id="btn-spinner" class="animate-spin h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </button>
                    </form>
                </div>

                <div id="success-message" class="absolute inset-0 flex flex-col justify-center items-center text-center opacity-0 pointer-events-none transform translate-y-10 transition-all duration-700 ease-out">
                    <div class="bg-green-100 p-4 rounded-full mb-4 shadow-sm"><i data-feather="check" class="w-12 h-12 text-green-600"></i></div>
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
            <h3 class="text-xl font-bold mb-4 text-[#1e3a8a]">Eligibility Check</h3>
            
            <form action="https://api.web3forms.com/submit" method="POST">
                <input type="hidden" name="access_key" value="<?php echo $web3FormsKey; ?>">
                <input type="hidden" name="subject" value="New Eligibility Check - Laurentiu Niculescu">
                <input type="hidden" name="from_name" value="Eligibility Form">

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q1">1. City / Oraș</label>
                        <input type="text" name="city" class="input-standard" required>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q2">2. Residency Status</label>
                        <select name="residency" class="input-standard">
                            <option value="Pre-settle">Pre-settle</option>
                            <option value="Settle">Settle</option>
                            <option value="British Citizen">British Citizen</option>
                            <option value="Refugee">Refugee</option>
                            <option value="Ukraine Scheme">Ukraine Scheme</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q3">3. English Level</label>
                        <select name="english_level" class="input-standard">
                            <option value="Basic">Basic</option>
                            <option value="Medium">Medium</option>
                            <option value="Conversational">Conversational (Can Speak/Understand)</option>
                            <option value="Advanced">Advanced</option>
                            <option value="None">None</option>
                        </select>
                        <div class="mt-2 text-center">
                            <a href="https://englishtest.duolingo.com/applicants" target="_blank" class="text-[#1e3a8a] underline text-xs font-bold hover:text-[#1e40af]" data-key="link_duolingo_check">
                                Not sure about the level of english take this test
                            </a>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q4">4. Diploma (Bac, Lvl 3, A-Levels, BTEC)</label>
                        <input type="text" name="diploma" class="input-standard" placeholder="Yes (Which?) / No">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q5">5. Course Type</label>
                        <select name="course_type" class="input-standard">
                            <option value="Undergraduate">Undergraduate</option>
                            <option value="Postgraduate (Master)">Postgraduate (Master)</option>
                            <option value="Second Degree">Second Degree</option>
                            <option value="Full Online">Full Online (No Maintenance)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q6">6. Field of Study</label>
                        <input type="text" name="field" class="input-standard" placeholder="e.g. Business, Health..." required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q7">7. Preferred Schedule</label>
                        <select name="schedule" class="input-standard">
                            <option value="2 Days x 4h">2 Days x 4h</option>
                            <option value="1 Day Online / 1 Day Campus">One day online and one day on campus</option>
                            <option value="Weekend">Weekend</option>
                            <option value="Daytime">Daytime</option>
                            <option value="Evening">Evening</option>
                            <option value="2 Days Full">2 Days Full (8h)</option>
                            <option value="Mix">2 Evenings Online + 1 Day Campus</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q8">8. Willing to study in London?</label>
                        <select name="london_study" class="input-standard">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full btn-blue" data-key="btn_submit_elig">Submit Answers</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<footer class="bg-white text-gray-700 py-12 text-center mt-12 border-t border-gray-200">
        <div class="flex justify-center gap-4 mb-8 footer-socials">
            <a href="https://www.facebook.com/niculescu.laurentiu.9/" target="_blank" class="icon-fb" aria-label="Facebook">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="https://wa.me/447853610930" target="_blank" class="icon-wa" aria-label="WhatsApp">
                <i class="fab fa-whatsapp"></i>
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
    
    // Global variables for pagination
    let allSortedResults = [];
    let currentPage = 1;
    const resultsPerPage = 5;

    function toggleMobileMenu() { document.getElementById('mobile-menu').style.display = (document.getElementById('mobile-menu').style.display === 'flex') ? 'none' : 'flex'; }
    function toggleSearch() { document.getElementById('search-container').classList.toggle('hidden'); }
    function openEligibilityModal() { document.getElementById('eligibility-modal').style.display = 'flex'; }
    function closeEligibilityModal() { document.getElementById('eligibility-modal').style.display = 'none'; }
    window.onclick = function(event) { if(event.target == document.getElementById('eligibility-modal')) closeEligibilityModal(); }  

    async function handleSearch(e) {
        e.preventDefault();
        
        const userLocation = document.getElementById('user-postcode').value.trim().toLowerCase();
        const userLevel = document.getElementById('user-level').value;
        const userSubject = document.getElementById('user-subject').value;
        
        const div = document.getElementById('results-area');
        const spinner = document.getElementById('loading-spinner');
        const pagControls = document.getElementById('pagination-controls');

        // Validation
        if(!userLocation) return alert("Please enter a City.");

        // Reset UI
        div.innerHTML = '';
        spinner.classList.remove('hidden');
        if(pagControls) pagControls.classList.add('hidden');
        allSortedResults = []; 

        setTimeout(() => {
            allSortedResults = coursesDB.filter(course => {
                // A. City Match (Checks if course city includes user input)
                const courseCity = (course.city || "").toLowerCase();
                const courseAddress = (course.address || "").toLowerCase();
                const isLocationMatch = courseCity.includes(userLocation) || courseAddress.includes(userLocation);

                // B. Level Match
                const dbLevel = (course.level || "").toLowerCase();
                const selLevel = userLevel.toLowerCase();
                const isLevelMatch = (userLevel === 'All') || 
                                     (dbLevel.includes(selLevel)) || 
                                     (selLevel === "year 1" && dbLevel.includes("level 4")) ||
                                     (selLevel === "year 2" && dbLevel.includes("level 5")) ||
                                     (selLevel === "top-up" && dbLevel.includes("level 6")) ||
                                     (selLevel === "master" && (dbLevel.includes("master") || dbLevel.includes("level 7")));

                // C. Subject Match
                const isSubjectMatch = (userSubject === 'All') || (course.subject === userSubject);

                return isLocationMatch && isLevelMatch && isSubjectMatch;
            });

            spinner.classList.add('hidden');

            if (allSortedResults.length > 0) {
                currentPage = 1;
                renderPage(1);
            } else {
                div.innerHTML = `
                <div class="p-6 bg-white border border-gray-200 rounded-xl text-center text-gray-500">
                    <p class="font-bold text-lg mb-2">No courses found in "${document.getElementById('user-postcode').value}"</p>
                    <p class="text-sm">Try searching for a nearby major city (e.g., London, Manchester).</p>
                </div>`;
            }
        }, 600); // 0.6s delay for effect
    };
    function renderPage(page) {
        const div = document.getElementById('results-area');
        const pagControls = document.getElementById('pagination-controls');
        const indicator = document.getElementById('page-indicator');
        
        div.innerHTML = '';
        
        const start = (page - 1) * resultsPerPage;
        const end = start + resultsPerPage;
        const pageItems = allSortedResults.slice(start, end);

        pageItems.forEach(c => {
             // Safe title handling
             const courseTitle = c.title || c.courses[0] || "Course";
             // Clean title for passing to JS function (escapes quotes)
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
                            <span class="flex items-center gap-1.5">
                                <i data-feather="map-pin" class="w-3 h-3 text-red-500"></i> ${c.city || 'Campus'}
                            </span>
                            <span class="flex items-center gap-1.5">
                                <i data-feather="book-open" class="w-3 h-3 text-blue-500"></i> ${c.subject || 'General'}
                            </span>
                             <span class="flex items-center gap-1.5">
                                <i data-feather="clock" class="w-3 h-3 text-amber-500"></i> ${c.study_schedule || 'Flexible'}
                            </span>
                        </div>
                    </div>
                    
                    <div class="text-right sm:text-right w-full sm:w-auto flex flex-row sm:flex-col items-center sm:items-end justify-between border-t sm:border-0 pt-3 sm:pt-0 border-slate-100 mt-2 sm:mt-0">
                        <div class="mb-0 sm:mb-3 text-left sm:text-right">
                            <span class="block text-lg font-bold text-emerald-600">Available</span>
                        </div>
                        
                        <a href="#contact" 
                           onclick="document.querySelector('textarea[name=\\'message\\']').value = 'I am interested in applying for: ${safeTitle} (${c.level}). Please contact me details.';"
                           class="btn-blue text-xs px-6 py-2 shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5">
                           Apply Now
                        </a>
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
    const translations = {
    en: {
        site_title: "One Guide",
        nav_courses: "Courses", nav_eligibility: "Eligibility", nav_contact: "Contact", 
        nav_tagline: "We help you find the right direction",
        role: "Student Advisor & Academic Coach", 
        hero_slogan: "\"Guiding you through the academic maze with clarity and confidence.\"",
        btn_contact: "Get in Touch", btn_back: "Back to Team",

        search_title: "Search Accredited Courses", btn_find: "Find",
        lbl_postcode: "Postcode / City", lbl_level: "Level", lbl_subject: "Subject", lbl_travel: "Travel",

        about_title: "Turning Ambition into Achievement", about_sub: "Dedicated support for your academic journey.",
     bio_p1: "I’m not here to throw academic jargon at you. I’m here to help you get into college—without the stress and confusion. My job is to guide you through the maze of applications, course choices, and personal statements.",
bio_quote: "\"My style is student-centered and fully committed to making your application stand out.\"",
        
        values_title: "Why Choose Me?", 
        val_1: "Understanding of requirements", 
        val_2: "Student Finance support", 
        val_3: "Honest communication",

        prep_title: "Interview Preparation", prep_sub: "Master the skills needed for your university interview.",
        star_t: "STAR Method", star_d: "Master behavioral questions.",
        psych_t: "Psychometric", psych_d: "Logic & reasoning practice.",
        case_t: "Case Studies", case_d: "Real-world scenarios.",

        elig_title: "Check Your Eligibility", elig_desc: "Answer a few questions to see if you qualify for Student Finance.", btn_check_elig: "Answer Questions",
        lbl_q1: "1. City / Town", lbl_q2: "2. Residency Status", lbl_q3: "3. English Level", link_duolingo_check: "Not sure? Take test",
        lbl_q4: "4. Diploma?", lbl_q5: "5. Course Type", lbl_q6: "6. Field of Study", lbl_q7: "7. Schedule", lbl_q8: "8. London?", btn_submit_elig: "Submit Answers",

        test_title: "Validate Your English Proficiency", test_desc: "Take the official Duolingo English Test online.", btn_test: "Take Duolingo Test",

        contact_title: "Contact Me", contact_sub: "Ready to turn your dream into reality? Fill in the details below.",
        form_header: "Contact Me", ph_name: "Full Name", ph_phone: "Phone Number", ph_email: "Email Address", ph_msg: "How can I help?", btn_send: "Send Message"
    },

    ro: {
        site_title: "One Guide",
        nav_courses: "Cursuri", nav_eligibility: "Eligibilitate", nav_contact: "Contact", 
        nav_tagline: "Te ajutăm să găsești direcția corectă",
        role: "Consilier Student & Coach Academic", 
        hero_slogan: "\"Te ghidez prin labirintul academic cu claritate și încredere.\"",
        btn_contact: "Contactează-mă", btn_back: "Înapoi la Echipă",

        search_title: "Caută Cursuri Acreditate", btn_find: "Caută",
        lbl_postcode: "Cod Poștal / Oraș", lbl_level: "Nivel", lbl_subject: "Subiect", lbl_travel: "Transport",

        about_title: "Transformăm Ambiția în Realizare", about_sub: "Suport dedicat pentru călătoria ta academică.",
       bio_p1: "Nu sunt aici să te bombardez cu jargon academic. Sunt aici să te ajut să intri la facultate—fără stres și confuzie. Treaba mea este să te ghidez prin labirintul aplicațiilor, alegerii cursurilor și eseurilor personale.",
bio_quote: "\"Stilul meu este centrat pe student și dedicat complet pentru a face aplicația ta să iasă în evidență.\"",
        
        values_title: "De ce Eu?", 
        val_1: "Înțelegerea cerințelor", 
        val_2: "Suport Student Finance", 
        val_3: "Comunicare onestă",

        prep_title: "Pregătire Interviu", prep_sub: "Stăpânește abilitățile necesare.",
        star_t: "Metoda STAR", star_d: "Întrebări comportamentale.",
        psych_t: "Psihometric", psych_d: "Logică și raționament.",
        case_t: "Studii de Caz", case_d: "Scenarii reale.",

        elig_title: "Verifică Eligibilitatea", elig_desc: "Răspunde la întrebări pentru a vedea dacă te califici.", btn_check_elig: "Verifică Acum",
        lbl_q1: "1. Oraș", lbl_q2: "2. Statut Rezidență", lbl_q3: "3. Nivel Engleză", link_duolingo_check: "Nu ești sigur? Fă testul",
        lbl_q4: "4. Diplomă", lbl_q5: "5. Tip Curs", lbl_q6: "6. Domeniu", lbl_q7: "7. Program", lbl_q8: "8. Londra?", btn_submit_elig: "Trimite",

        test_title: "Validează Engleza", test_desc: "Susține testul oficial Duolingo online.", btn_test: "Fă Testul",

        contact_title: "Contactează-mă", contact_sub: "Gata să îți transformi visul în realitate?",
        form_header: "Contactează-mă", ph_name: "Nume Complet", ph_phone: "Telefon", ph_email: "Email", ph_msg: "Cum te pot ajuta?", btn_send: "Trimite Mesaj"
    },

    pl: {
        site_title: "One Guide",
        nav_courses: "Kursy", nav_eligibility: "Kwalifikowalność", nav_contact: "Kontakt", 
        nav_tagline: "Pomożemy Ci znaleźć właściwy kierunek",
        role: "Doradca Studenta i Trener Akademicki", 
        hero_slogan: "\"Prowadzę Cię przez labirynt akademicki z jasnością i pewnością.\"",
        btn_contact: "Skontaktuj się", btn_back: "Powrót",

        search_title: "Szukaj Kursów", btn_find: "Szukaj",
        lbl_postcode: "Kod / Miasto", lbl_level: "Poziom", lbl_subject: "Kierunek", lbl_travel: "Dojazd",

        about_title: "Przekuwamy Ambicje w Osiągnięcia", about_sub: "Dedykowane wsparcie w Twojej podróży akademickiej.",
        bio_p1: "Nie jestem tu po to, by zarzucać Cię akademickim żargonem. Jestem tu, aby pomóc Ci dostać się na studia – bez stresu i zamieszania. Moim zadaniem jest przeprowadzenie Cię przez labirynt aplikacji, wyboru kierunków i listów motywacyjnych.",
bio_quote: "\"Mój styl koncentruje się na studencie i pełnym zaangażowaniu w to, by Twoja aplikacja się wyróżniała.\"",
        
        values_title: "Dlaczego Ja?", 
        val_1: "Zrozumienie wymagań", 
        val_2: "Wsparcie finansowe", 
        val_3: "Uczciwa komunikacja",

        prep_title: "Przygotowanie do Rozmowy", prep_sub: "Opanuj umiejętności.",
        star_t: "Metoda STAR", star_d: "Pytania behawioralne.",
        psych_t: "Psychometryczne", psych_d: "Logika i rozumowanie.",
        case_t: "Studium Przypadku", case_d: "Scenariusze.",

        elig_title: "Sprawdź Kwalifikowalność", elig_desc: "Odpowiedz na pytania.", btn_check_elig: "Sprawdź",
        lbl_q1: "1. Miasto", lbl_q2: "2. Status", lbl_q3: "3. Angielski", link_duolingo_check: "Niepewny? Test",
        lbl_q4: "4. Dyplom", lbl_q5: "5. Typ", lbl_q6: "6. Kierunek", lbl_q7: "7. Harmonogram", lbl_q8: "8. Londyn?", btn_submit_elig: "Wyślij",

        test_title: "Potwierdź Angielski", test_desc: "Zrób test Duolingo online.", btn_test: "Zrób Test",

        contact_title: "Kontakt", contact_sub: "Gotowy na realizację marzeń?",
        form_header: "Kontakt", ph_name: "Imię i Nazwisko", ph_phone: "Telefon", ph_email: "Email", ph_msg: "Jak mogę pomóc?", btn_send: "Wyślij"
    },

    hu: {
        site_title: "One Guide",
        nav_courses: "Tanfolyamok", nav_eligibility: "Jogosultság", nav_contact: "Kapcsolat", 
        nav_tagline: "Segítünk megtalálni a helyes irányt",
        role: "Diáktanácsadó és Akadémiai Coach", 
        hero_slogan: "\"Világosan és magabiztosan vezetlek át az akadémiai útvesztőn.\"",
        btn_contact: "Kapcsolat", btn_back: "Vissza",

        search_title: "Keresés", btn_find: "Keresés",
        lbl_postcode: "Irányítószám / Város", lbl_level: "Szint", lbl_subject: "Tárgy", lbl_travel: "Utazás",

        about_title: "Az Ambíció Megvalósítása", about_sub: "Elkötelezett támogatás.",
       bio_p1: "Nem azért vagyok itt, hogy akadémiai szakzsargonnal dobálózzak. Azért vagyok itt, hogy segítsek bejutni az egyetemre – stressz és zűrzavar nélkül. A feladatom az, hogy átvezessem a jelentkezések, kurzusválasztások és motivációs levelek útvesztőjén.",
bio_quote: "\"Stílusom diákközpontú, és teljes mértékben elkötelezett amellett, hogy jelentkezésed kiemelkedő legyen.\"",
        
        values_title: "Miért Én?", 
        val_1: "Követelmények ismerete", 
        val_2: "Pénzügyi támogatás", 
        val_3: "Őszinte kommunikáció",

        prep_title: "Interjú Felkészülés", prep_sub: "Sajátítsd el a készségeket.",
        star_t: "STAR Módszer", star_d: "Viselkedési kérdések.",
        psych_t: "Pszichometria", psych_d: "Logika.",
        case_t: "Esettanulmány", case_d: "Forgatókönyvek.",

        elig_title: "Jogosultság Ellenőrzése", elig_desc: "Válaszolj a kérdésekre.", btn_check_elig: "Válaszadás",
        lbl_q1: "1. Város", lbl_q2: "2. Státusz", lbl_q3: "3. Angol", link_duolingo_check: "Teszt",
        lbl_q4: "4. Diploma", lbl_q5: "5. Típus", lbl_q6: "6. Terület", lbl_q7: "7. Idő", lbl_q8: "8. London?", btn_submit_elig: "Küldés",

        test_title: "Igazold Angol Tudásod", test_desc: "Végezd el a tesztet online.", btn_test: "Teszt Indítása",

        contact_title: "Kapcsolat", contact_sub: "Készen állsz?",
        form_header: "Kapcsolat", ph_name: "Név", ph_phone: "Telefon", ph_email: "Email", ph_msg: "Miben segíthetek?", btn_send: "Küldés"
    },

    es: {
        site_title: "One Guide",
        nav_courses: "Cursos", nav_eligibility: "Elegibilidad", nav_contact: "Contacto", 
        nav_tagline: "Te ayudamos a encontrar el camino correcto",
        role: "Asesor Estudiantil y Coach Académico", 
        hero_slogan: "\"Guiándote por el laberinto académico con claridad y confianza.\"",
        btn_contact: "Contactar", btn_back: "Volver",

        search_title: "Buscar Cursos", btn_find: "Buscar",
        lbl_postcode: "Código / Ciudad", lbl_level: "Nivel", lbl_subject: "Tema", lbl_travel: "Viaje",

        about_title: "Convirtiendo la Ambición en Logros", about_sub: "Apoyo dedicado.",
        bio_p1: "No estoy aquí para lanzarte jerga académica. Estoy aquí para ayudarte a entrar en la universidad, sin estrés ni confusión. Mi trabajo es guiarte a través del labirinto de solicitudes, elección de cursos y declaraciones personales.",
bio_quote: "\"Mi estilo está centrado en el estudiante y totalmente comprometido a hacer que tu solicitud destaque.\"",
        
        values_title: "¿Por Qué Elegirme?", 
        val_1: "Comprensión de requisitos", 
        val_2: "Apoyo financiero", 
        val_3: "Comunicación honesta",

        prep_title: "Preparación Entrevista", prep_sub: "Domina la entrevista.",
        star_t: "Método STAR", star_d: "Comportamiento.",
        psych_t: "Psicométrico", psych_d: "Lógica.",
        case_t: "Casos", case_d: "Escenarios.",

        elig_title: "Verificar Elegibilidad", elig_desc: "Responde preguntas.", btn_check_elig: "Verificar",
        lbl_q1: "1. Ciudad", lbl_q2: "2. Estado", lbl_q3: "3. Inglés", link_duolingo_check: "Test",
        lbl_q4: "4. Diploma", lbl_q5: "5. Tipo", lbl_q6: "6. Campo", lbl_q7: "7. Horario", lbl_q8: "8. ¿Londres?", btn_submit_elig: "Enviar",

        test_title: "Valida tu Inglés", test_desc: "Haz el examen online.", btn_test: "Tomar Test",

        contact_title: "Contacto", contact_sub: "¿Listo para empezar?",
        form_header: "Contacto", ph_name: "Nombre", ph_phone: "Teléfono", ph_email: "Email", ph_msg: "¿Cómo ayudo?", btn_send: "Enviar"
    },

    it: {
        site_title: "One Guide",
        nav_courses: "Corsi", nav_eligibility: "Idoneità", nav_contact: "Contatti", 
        nav_tagline: "Ti aiutiamo a trovare la giusta direzione",
        role: "Consulente Studentesco e Coach Accademico", 
        hero_slogan: "\"Guidandoti nel labirinto accademico con chiarezza e fiducia.\"",
        btn_contact: "Contattami", btn_back: "Indietro",

        search_title: "Cerca Corsi", btn_find: "Cerca",
        lbl_postcode: "CAP / Città", lbl_level: "Livello", lbl_subject: "Materia", lbl_travel: "Viaggio",

        about_title: "Trasformare l'Ambizione in Successo", about_sub: "Supporto dedicato.",
        bio_p1: "Non sono qui per lanciarti addosso gergo accademico. Sono qui per aiutarti ad entrare all'università, senza stress e confusione. Il mio lavoro è guidarti attraverso il labirinto delle candidature, delle scelte dei corsi e delle lettere di presentazione.",
bio_quote: "\"Il mio stile è incentrato sullo studente e pienamente impegnato a far risaltare la tua candidatura.\"",
        
        values_title: "Perché Scegliere Me?", 
        val_1: "Comprensione requisiti", 
        val_2: "Supporto finanziario", 
        val_3: "Comunicazione onesta",

        prep_title: "Preparazione Colloquio", prep_sub: "Migliora le abilità.",
        star_t: "Metodo STAR", star_d: "Comportamentale.",
        psych_t: "Psicometrico", psych_d: "Logica.",
        case_t: "Casi Studio", case_d: "Scenari.",

        elig_title: "Verifica Idoneità", elig_desc: "Rispondi alle domande.", btn_check_elig: "Verifica",
        lbl_q1: "1. Città", lbl_q2: "2. Stato", lbl_q3: "3. Inglese", link_duolingo_check: "Test",
        lbl_q4: "4. Diploma", lbl_q5: "5. Tipo", lbl_q6: "6. Campo", lbl_q7: "7. Orario", lbl_q8: "8. Londra?", btn_submit_elig: "Invia",

        test_title: "Convalida Inglese", test_desc: "Fai il test online.", btn_test: "Fai Test",

        contact_title: "Contatti", contact_sub: "Pronto a iniziare?",
        form_header: "Contatti", ph_name: "Nome", ph_phone: "Telefono", ph_email: "Email", ph_msg: "Messaggio", btn_send: "Invia"
    },

    pt: {
        site_title: "One Guide",
        nav_courses: "Cursos", nav_eligibility: "Elegibilidade", nav_contact: "Contato", 
        nav_tagline: "Ajudamos você a encontrar a direção certa",
        role: "Consultor Estudantil e Coach Acadêmico", 
        hero_slogan: "\"Guiando você pelo labirinto acadêmico com clareza e confiança.\"",
        btn_contact: "Contato", btn_back: "Voltar",

        search_title: "Buscar Cursos", btn_find: "Buscar",
        lbl_postcode: "Código / Cidade", lbl_level: "Nível", lbl_subject: "Assunto", lbl_travel: "Viagem",

        about_title: "Transformando Ambição em Conquista", about_sub: "Apoio dedicado.",
        bio_p1: "Não estou aqui para lhe atirar jargão académico. Estou aqui para ajudá-lo a entrar na universidade – sem stress e confusão. O meu trabalho é guiá-lo através do labirinto de candidaturas, escolhas de cursos e declarações pessoais.",
bio_quote: "\"O meu estilo é centrado no aluno e totalmente empenhado em fazer com que a sua candidatura se destaque.\"",
        
        values_title: "Porquê Eu?", 
        val_1: "Compreensão dos requisitos", 
        val_2: "Apoio financeiro", 
        val_3: "Comunicação honesta",

        prep_title: "Preparação Entrevista", prep_sub: "Domine a entrevista.",
        star_t: "Método STAR", star_d: "Comportamental.",
        psych_t: "Psicométrico", psych_d: "Lógica.",
        case_t: "Estudos de Caso", case_d: "Cenários.",

        elig_title: "Verificar Elegibilidade", elig_desc: "Responda perguntas.", btn_check_elig: "Verificar",
        lbl_q1: "1. Cidade", lbl_q2: "2. Estado", lbl_q3: "3. Inglês", link_duolingo_check: "Teste",
        lbl_q4: "4. Diploma", lbl_q5: "5. Tipo", lbl_q6: "6. Área", lbl_q7: "7. Horário", lbl_q8: "8. Londres?", btn_submit_elig: "Enviar",

        test_title: "Valide seu Inglês", test_desc: "Faça o teste online.", btn_test: "Fazer Teste",

        contact_title: "Contato", contact_sub: "Pronto?",
        form_header: "Contato", ph_name: "Nome", ph_phone: "Telefone", ph_email: "Email", ph_msg: "Mensagem", btn_send: "Enviar"
    },

    el: {
        site_title: "One Guide",
        nav_courses: "Μαθήματα", nav_eligibility: "Επιλεξιμότητα", nav_contact: "Επαφή", 
        nav_tagline: "Σας βοηθάμε να βρείτε τη σωστή κατεύθυνση",
        role: "Σύμβουλος Φοιτητών", 
        hero_slogan: "\"Καθοδήγηση με σαφήνεια και εμπιστοσύνη.\"",
        btn_contact: "Επικοινωνία", btn_back: "Πίσω",

        search_title: "Αναζήτηση", btn_find: "Εύρεση",
        lbl_postcode: "ΤΚ / Πόλη", lbl_level: "Επίπεδο", lbl_subject: "Θέμα", lbl_travel: "Ταξίδι",

        about_title: "Φιλοδοξία σε Επιτυχία", about_sub: "Αφιερωμένη υποστήριξη.",
      bio_p1: "Δεν είμαι εδώ για να σας φορτώσω με ακαδημαϊκή ορολογία. Είμαι εδώ για να σας βοηθήσω να μπείτε στο πανεπιστήμιο—χωρίς άγχος και σύγχυση. Η δουλειά μου είναι να σας καθοδηγήσω μέσα από τον λαβύρινθο των αιτήσεων, των επιλογών μαθημάτων και των προσωπικών δηλώσεων.",
bio_quote: "\"Το στυλ μου είναι μαθητοκεντρικό και πλήρως αφοσιωμένο στο να κάνει την αίτησή σας να ξεχωρίσει.\"",
        values_title: "Γιατί Εγώ;", 
        val_1: "Κατανόηση απαιτήσεων", 
        val_2: "Οικονομική υποστήριξη", 
        val_3: "Ειλικρίνεια",

        prep_title: "Προετοιμασία", prep_sub: "Δεξιότητες.",
        star_t: "STAR", star_d: "Συμπεριφορά.",
        psych_t: "Ψυχομετρικά", psych_d: "Λογική.",
        case_t: "Μελέτες", case_d: "Σενάρια.",

        elig_title: "Επιλεξιμότητα", elig_desc: "Έλεγχος.", btn_check_elig: "Έλεγχος",
        lbl_q1: "1. Πόλη", lbl_q2: "2. Καθεστώς", lbl_q3: "3. Αγγλικά", link_duolingo_check: "Τεστ",
        lbl_q4: "4. Δίπλωμα", lbl_q5: "5. Τύπος", lbl_q6: "6. Πεδίο", lbl_q7: "7. Πρόγραμμα", lbl_q8: "8. Λονδίνο;", btn_submit_elig: "Υποβολή",

        test_title: "Αγγλικά", test_desc: "Κάντε το τεστ.", btn_test: "Τεστ",

        contact_title: "Επαφή", contact_sub: "Έτοιμοι;",
        form_header: "Επαφή", ph_name: "Όνομα", ph_phone: "Τηλ", ph_email: "Email", ph_msg: "Μήνυμα", btn_send: "Αποστολή"
    },

    bg: {
        site_title: "One Guide",
        nav_courses: "Курсове", nav_eligibility: "Допустимост", nav_contact: "Контакт", 
        nav_tagline: "Ние ви помагаме да намерите правилната посока",
        role: "Студентски Консултант", 
        hero_slogan: "\"Насочване през лабиринта с яснота и увереност.\"",
        btn_contact: "Контакт", btn_back: "Назад",

        search_title: "Търсене", btn_find: "Търси",
        lbl_postcode: "Град", lbl_level: "Ниво", lbl_subject: "Предмет", lbl_travel: "Път",

        about_title: "Амбиция в Успех", about_sub: "Подкрепа.",
        bio_p1: "Не съм тук, за да ви засипвам с академичен жаргон. Тук съм, за да ви помогна да влезете в колеж – без стрес и объркване. Моята работа е да ви преведа през лабиринта от кандидатствания, избор на курсове и лични изявления.",
bio_quote: "\"Моят стил е ориентиран към студента и напълно ангажиран с това кандидатурата ви да изпъкне.\"",
        values_title: "Защо Аз?", 
        val_1: "Разбиране на изискванията", 
        val_2: "Финансова подкрепа", 
        val_3: "Честност",

        prep_title: "Подготовка", prep_sub: "Умения.",
        star_t: "STAR", star_d: "Поведение.",
        psych_t: "Психометрични", psych_d: "Логика.",
        case_t: "Казуси", case_d: "Сценарии.",

        elig_title: "Допустимост", elig_desc: "Проверка.", btn_check_elig: "Проверка",
        lbl_q1: "1. Град", lbl_q2: "2. Статус", lbl_q3: "3. Английски", link_duolingo_check: "Тест",
        lbl_q4: "4. Диплома", lbl_q5: "5. Тип", lbl_q6: "6. Сфера", lbl_q7: "7. График", lbl_q8: "8. Лондон?", btn_submit_elig: "Изпрати",

        test_title: "Английски", test_desc: "Направете теста.", btn_test: "Тест",

        contact_title: "Контакт", contact_sub: "Готови?",
        form_header: "Контакт", ph_name: "Име", ph_phone: "Тел", ph_email: "Имейл", ph_msg: "Съобщение", btn_send: "Изпрати"
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
    const contactForm = document.getElementById('laurentiu-contact-form');
    const formWrapper = document.getElementById('contact-form-wrapper');
    const successMsg = document.getElementById('success-message');
    const submitBtn = document.getElementById('submit-btn');
    const btnText = document.getElementById('btn-text');
    const btnIcon = document.getElementById('btn-icon');
    const btnSpinner = document.getElementById('btn-spinner');

    if(contactForm) {
        contactForm.addEventListener('submit', async function(e) {
            e.preventDefault(); // Prevent page reload

            btnText.classList.add('hidden');
            btnIcon.classList.add('hidden');
            btnSpinner.classList.remove('hidden');
            submitBtn.disabled = true;

            const formData = new FormData(contactForm);

            try {
                const response = await fetch('https://api.web3forms.com/submit', {
                    method: 'POST',
                    body: formData
                });

                if (response.status === 200) {
                    // Fade out form
                    formWrapper.classList.add('opacity-0', '-translate-y-10', 'pointer-events-none');
                    
                    // Fade in success message
                    setTimeout(() => {
                        successMsg.classList.remove('opacity-0', 'translate-y-10', 'pointer-events-none');
                    }, 300);
                    
                    contactForm.reset();
                } else {
                    alert("Something went wrong. Please try again.");
                }
            } catch (error) {
                console.error("Error:", error);
                alert("Error sending message. Please check your connection.");
            } finally {
                btnText.classList.remove('hidden');
                btnIcon.classList.remove('hidden');
                btnSpinner.classList.add('hidden');
                submitBtn.disabled = false;
            }
        });
    }

    // Function to reset the view if user clicks "Send another message"
    function resetForm() {
        successMsg.classList.add('opacity-0', 'translate-y-10', 'pointer-events-none');
        setTimeout(() => {
            formWrapper.classList.remove('opacity-0', '-translate-y-10', 'pointer-events-none');
        }, 300);
    }
    </script>
</body>
</html>
