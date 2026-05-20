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

foreach ($jsonFiles as $file) {
    $filePath = $baseDir . '/' . $file;
    if (file_exists($filePath)) {
        $content = file_get_contents($filePath);
        $data = json_decode($content, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
            $allCourses = array_merge($allCourses, $data);
        }
    }
}

$coursesJson = json_encode($allCourses);

$web3FormsKey = "{your api here}"; 
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ovidiu-Horia Suteu | Student Adviser</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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
        
        #bg-fixed { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -2; background-image: url('<?php echo get_template_directory_uri(); ?>/images/background.png'); background-position: center center; background-repeat: no-repeat; background-size: cover; }
        #bg-veil { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(4px); }
        
        nav { background: rgba(255, 255, 255, 0.95); border-bottom: 1px solid var(--border-color); box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .content-card { background: #ffffff; border-radius: 1.5rem; padding: 2.5rem; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05); border: 1px solid var(--border-color); }
        .input-standard { background: #f9fafb; border: 1px solid #d1d5db; color: #1f2937; border-radius: 0.5rem; padding: 0.75rem; width: 100%; transition: all 0.2s; }
        .input-standard:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1); outline: none; background: #ffffff; }
        .btn-blue { background-color: var(--primary); color: white; padding: 12px 30px; border-radius: 8px; font-weight: 700; transition: transform 0.2s; display: inline-block; cursor: pointer; text-align: center; }
        .btn-blue:hover { background-color: #1e40af; transform: translateY(-2px); }
        .btn-outline-blue { background: transparent; border: 2px solid var(--primary); color: var(--primary); padding: 10px 28px; border-radius: 8px; font-weight: 700; transition: all 0.2s; display: inline-block; text-align: center; }
        .btn-outline-blue:hover { background: var(--primary); color: white; }

        .prep-card { background: #ffffff; border: 1px solid #e2e8f0; color: var(--primary); padding: 2rem; border-radius: 1rem; transition: transform 0.2s; display: block; text-align: center; height: 100%; }
        .prep-card:hover { transform: translateY(-5px); border-color: var(--primary); box-shadow: 0 10px 20px rgba(30, 58, 138, 0.1); }

        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; display: none; justify-content: center; align-items: center; padding: 20px; }
        .modal-content { background: white; width: 100%; max-width: 600px; border-radius: 1rem; padding: 30px; position: relative; max-height: 90vh; overflow-y: auto; animation: slideUp 0.3s ease; }
        @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

        footer { background: #ffffff; border-top: 1px solid var(--border-color); }

        #mobile-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: white;
            border-top: 1px solid #e2e8f0;
            flex-direction: column;
            padding: 1rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            z-index: 40;
            animation: slideDown 0.3s ease-out;
        }

        #mobile-menu.active { display: flex; }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

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
            
            <div class="hidden md:flex gap-8 items-left font-medium text-gray-600">
                <a href="#course-search" class="hover:text-[#1e3a8a] transition" data-key="nav_courses">Courses</a>
                <a href="#eligibility" class="hover:text-[#1e3a8a] transition" data-key="nav_eligibility">Eligibility</a>
                
                <div class="relative inline-block">
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
                </div>
                
                <a href="#contact" class="btn-blue shadow-md" data-key="btn_contact">Contact</a>
            </div>

            <button class="md:hidden p-2 text-slate-600 border border-slate-300 rounded-lg hover:bg-slate-100 transition mobile-toggle" onclick="toggleMobileMenu()">
                <i data-feather="menu"></i>
            </button>

            <div id="mobile-menu">
                <a href="#course-search" class="block py-3 font-medium text-gray-600 hover:text-[#1e3a8a]" onclick="toggleMobileMenu()" data-key="nav_courses">Courses</a>
                <a href="#eligibility" class="block py-3 font-medium text-gray-600 hover:text-[#1e3a8a]" onclick="toggleMobileMenu()" data-key="nav_eligibility">Eligibility</a>
                <div class="border-t border-gray-100 pt-4 mt-2">
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
                </div>
                <a href="#contact" class="btn-blue w-full mt-4 block text-center" onclick="toggleMobileMenu()" data-key="btn_contact">Contact</a>
            </div>
        </div>
    </nav>

    <main>
        <section class="pt-40 pb-24 px-6 border-b border-gray-100/50">
            <div class="max-w-5xl mx-auto flex flex-col md:flex-row items-center gap-12 fade-in">
                <div class="relative shrink-0">
                    <div class="absolute inset-0 bg-[#1e3a8a] blur-xl opacity-20 rounded-full"></div>
                    <img src="<?php echo get_template_directory_uri(); ?>/images/OvidiuHoriaSuteu.jpg" alt="Ovidiu Horia Suteu" class="relative w-64 h-64 rounded-full border-4 border-white shadow-2xl object-cover">
                </div>
                <div class="text-center md:text-left">
                    <h1 class="text-5xl font-bold text-slate-900 mb-2 serif-font">Ovidiu Horia Suteu</h1>
                    <p class="font-bold tracking-widest uppercase mb-6 text-[#ff7f7f]" data-key="role">Student Adviser & Academic Coach</p>
                    <p class="text-lg text-gray-600 mb-8 max-w-xl leading-relaxed italic" data-key="hero_slogan">"Your Future, My Priority."</p>
                    <div class="flex flex-wrap gap-4 justify-center md:justify-start">
                        <a href="#contact" class="btn-blue shadow-lg transition" data-key="btn_contact">Get in Touch</a>
                        <a href="<?php echo home_url('/#team'); ?>" class="btn-outline-blue" data-key="btn_back">Back to Team</a>
                    </div>
                </div>
            </div>
        </section>

        <section id="course-search" class="px-6 relative z-10 -mt-4">
            <div class="max-w-5xl mx-auto content-card text-center p-8">
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
                            <label class="text-xs font-bold uppercase mb-2 block" data-key="lbl_level">Level</label>
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
                            <label class="text-xs font-bold uppercase mb-2 block" data-key="lbl_subject">Subject</label>
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
                    
                                <div id="loading-spinner" class="hidden mt-6 text-blue-600 font-bold animate-pulse text-center">
                        <i data-feather="loader" class="animate-spin mr-2"></i> Searching...
                    </div>
                    
                    <div id="results-area" class="mt-8 space-y-4 text-left"></div>
                    
                    <div id="pagination-controls" class="hidden mt-6 flex justify-center gap-4">
                        <button onclick="changePage(-1)" class="px-4 py-2 bg-gray-100 border border-gray-300 rounded hover:bg-gray-200 text-gray-700">Previous</button>
                        <span id="page-indicator" class="px-4 py-2 text-gray-600 font-bold">Page 1</span>
                        <button onclick="changePage(1)" class="px-4 py-2 bg-gray-100 border border-gray-300 rounded hover:bg-gray-200 text-gray-700">Next</button>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 px-6">
            <div class="max-w-6xl mx-auto content-card">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-slate-900 serif-font" data-key="about_title">Turning Ambition into Achievement</h2>
                    <p class="text-slate-500 mt-2" data-key="about_sub">Dedicated support for your academic journey.</p>
                </div>
                <div class="grid lg:grid-cols-2 gap-12">
                    <div class="space-y-6 text-gray-700 text-lg leading-relaxed">
                        <p data-key="bio_p1">As an experienced Student Adviser, I specialize in application guidance, admissions support, and helping students understand their options and eligibility for university study.</p>
                        <div class="bg-[#eff6ff] p-6 rounded-xl border-l-4 border-[#1e3a8a] italic text-slate-800">
                            <p data-key="bio_quote">"I take a personalised approach, focusing on each student’s background, goals, and potential."</p>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-8 rounded-2xl border border-gray-200 h-fit shadow-sm">
                        <h4 class="font-bold text-xl text-[#1e3a8a] mb-6" data-key="values_title">Why Choose Me?</h4>
                        <ul class="space-y-4 text-gray-700">
                            <li class="flex items-center gap-3"><i data-feather="check-circle" class="text-[#ff7f7f]"></i> <span data-key="val_1">Understanding of requirements</span></li>
                            <li class="flex items-center gap-3"><i data-feather="check-circle" class="text-[#2563eb]"></i> <span data-key="val_2">Student Finance support</span></li>
                            <li class="flex items-center gap-3"><i data-feather="check-circle" class="text-amber-500"></i> <span data-key="val_3">Honest communication</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section id="prep" class="py-12 px-6">
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-bold serif-font text-blue-900" data-key="prep_title">Interview Preparation</h2>
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
            <div class="max-w-xl mx-auto content-card relative overflow-hidden" style="min-height: 400px;">
                
                <div id="contact-form-wrapper" class="transition-all duration-500 ease-in-out">
                    <h2 class="text-2xl font-bold text-center text-slate-900 mb-4" data-key="contact_title">Contact Me</h2>
                    <p class="text-center text-gray-500 mb-8" data-key="contact_sub">Direct contact for residency & eligibility queries.</p>
                    
                    <form id="ovidiu-contact-form" action="https://api.web3forms.com/submit" method="POST" class="space-y-5">
                        <input type="hidden" name="access_key" value="<?php echo $web3FormsKey; ?>">
                        <input type="hidden" name="subject" value="New Contact Request for Ovidiu Suteu">
                        <input type="hidden" name="from_name" value="One Guide Profile">

                        <input type="text" name="name" class="input-standard" data-key="ph_name" placeholder="Full Name" required>
                        <input type="tel" name="phone" class="input-standard" data-key="ph_phone" placeholder="Phone Number" required>
                        <input type="email" name="email" class="input-standard" data-key="ph_email" placeholder="Email Address" required>
                        <textarea name="message" rows="4" class="input-standard" data-key="ph_msg" placeholder="How can I help?" required></textarea>
                        
                        <button type="submit" id="submit-btn" class="w-full btn-blue flex justify-center items-center gap-2">
                            <span id="btn-text" data-key="btn_send">Send Request</span>
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

   <footer class="bg-gray-100 text-gray-500 py-12 text-center mt-12 border-t border-gray-200">
        <div class="flex flex-col items-center justify-center mb-6">
             <img src="<?php echo get_template_directory_uri(); ?>/images/One-Guide.png" alt="Logo" class="h-16 w-auto opacity-90 object-contain">
             <span class="brand-text text-gray-800 mt-2 text-xl font-bold">One Guide</span>
             <a href="https://www.ask33.co.uk/" target="_blank" class="text-[10px] text-gray-400 font-bold hover:text-red-600 transition mt-1 uppercase">Powered by ASK 33</a>
        </div>
        <p class="text-sm">Site by <a href="https://www.alphaitsolutions.uk" target="_blank" class="text-blue-500 hover:text-blue-700 font-bold transition">Alpha IT Solutions</a></p>
        <p class="text-xs mt-2 opacity-50">&copy; 2026 One Guide Advisors.</p>
    </footer>
    <div id="eligibility-modal" class="modal-overlay">
        <div class="modal-content">
            <button onclick="document.getElementById('eligibility-modal').style.display='none'" class="absolute top-4 right-4 text-gray-500 hover:text-red-500"><i data-feather="x"></i></button>
            <h3 class="text-xl font-bold mb-4 text-[#1e3a8a]">Eligibility Check</h3>
            
            <form action="https://api.web3forms.com/submit" method="POST">
                <input type="hidden" name="access_key" value="<?php echo $web3FormsKey; ?>">
                <input type="hidden" name="subject" value="New Eligibility Check - Ovidiu Suteu">
                <input type="hidden" name="from_name" value="Eligibility Form">

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q1">1. City / Oraș</label>
                        <input type="text" name="city" class="input-standard" required>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q2">2. Residency Status</label>
                        <select name="residency" class="input-standard">
                            <option value="Pre-settle (Working)">Pre-settle (Working)</option>
                            <option value="Pre-settle (Not Working)">Pre-settle (Not Working)</option>
                            <option value="Settle Status">Settle Status</option>
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
                            <option value="Conversational">Conversational</option>
                            <option value="Advanced">Advanced</option>
                            <option value="None">None</option>
                        </select>
                        <div class="mt-2 text-center">
                            <a href="https://englishtest.duolingo.com/applicants" target="_blank" class="text-[#1e3a8a] underline text-xs font-bold hover:text-[#1e40af]" data-key="link_duolingo_check">
                                Not sure about the level? Take this test
                            </a>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q4">4. Diploma (Bac, Lvl 3, A-Levels)</label>
                        <input type="text" name="diploma" class="input-standard" placeholder="Yes (Which?) / No">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q5">5. Course Type</label>
                        <select name="course_type" class="input-standard">
                            <option value="Undergraduate">Undergraduate</option>
                            <option value="Postgraduate (Master)">Postgraduate (Master)</option>
                            <option value="Second Degree">Second Degree</option>
                            <option value="Full Online">Full Online</option>
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
                            <option value="1 Day Online / 1 Day Campus">1 Day Online + 1 Day Campus</option>
                            <option value="Weekend">Weekend</option>
                            <option value="Daytime">Daytime</option>
                            <option value="Evening">Evening</option>
                            <option value="Mix">Mix</option>
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

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        if (menu.classList.contains('active')) {
            menu.classList.remove('active');
        } else {
            menu.classList.add('active');
        }
    }

    function changeLanguage(lang) {
        const translations = {
            en: {
                // Nav
                nav_tagline: "We help you find the right direction",
                nav_courses: "Courses", nav_eligibility: "Eligibility", btn_contact: "Contact",
                
                // Hero
                role: "Student Adviser & Academic Coach",
                hero_slogan: "\"Your Future, My Priority.\"",
                btn_back: "Back to Team",

                // Search
                search_title: "Search Accredited Courses",
                lbl_postcode: "City", lbl_level: "Level", lbl_subject: "Subject", btn_find: "Find Course",

                // About
                about_title: "Turning Ambition into Achievement",
                about_sub: "Dedicated support for your academic journey.",
                bio_p1: "As an experienced Student Adviser, I specialize in application guidance, admissions support, and helping students understand their options and eligibility for university study.",
                bio_quote: "\"I take a personalised approach, focusing on each student’s background, goals, and potential.\"",
                values_title: "Why Choose Me?",
                val_1: "Understanding of requirements",
                val_2: "Student Finance support",
                val_3: "Honest communication",

                // Prep Cards
                prep_title: "Interview Preparation", prep_sub: "Master the skills needed for your university interview.",
                star_t: "STAR Method", star_d: "Master behavioral questions.",
                psych_t: "Ability Assessment", psych_d: "Logic & reasoning practice.",
                case_t: "Case Studies", case_d: "Real-world scenarios.",

                // Test
                test_title: "Validate Your English Proficiency", test_desc: "A certified English level is often required. Take the official Duolingo English Test online.", btn_test: "Take Duolingo Test",

                // Contact
                contact_title: "Contact Me", contact_sub: "Choose success! Contact me today.",
                ph_name: "Full Name", ph_phone: "Phone Number", ph_email: "Email Address", ph_msg: "How can I help?", btn_send: "Send Request",

                // Eligibility Modal
                elig_title: "Check Your Eligibility", elig_desc: "Answer a few questions to see if you qualify.", btn_check_elig: "Answer Questions",
                lbl_q1: "1. City", lbl_q2: "2. Residency Status", lbl_q3: "3. English Level", lbl_q4: "4. Diploma", lbl_q5: "5. Course Type", lbl_q6: "6. Field of Study", lbl_q7: "7. Schedule", lbl_q8: "8. Willing to study in London?", 
                link_duolingo_check: "Not sure about the level? Take this test",
                btn_submit_elig: "Submit Answers"
            },

            ro: {
                nav_tagline: "Te ajutăm să găsești direcția potrivită",
                nav_courses: "Cursuri", nav_eligibility: "Eligibilitate", btn_contact: "Contact",
                
                role: "Consilier Student & Coach Academic",
                hero_slogan: "\"Viitorul Tău, Prioritatea Mea.\"",
                btn_back: "Înapoi la Echipă",

                search_title: "Caută Cursuri Acreditate",
                lbl_postcode: "Oraș", lbl_level: "Nivel", lbl_subject: "Domeniu", btn_find: "Caută Curs",

                about_title: "Transformăm Ambiția în Realizare",
                about_sub: "Suport dedicat pentru călătoria ta academică.",
                bio_p1: "În calitate de Consilier Student cu experiență, mă specializez în ghidarea aplicațiilor, suport pentru admitere și ajut studenții să își înțeleagă opțiunile.",
                bio_quote: "\"Adopt o abordare personalizată, concentrându-mă pe istoricul, obiectivele și potențialul fiecărui student.\"",
                values_title: "De ce Eu?",
                val_1: "Înțelegerea cerințelor",
                val_2: "Suport Student Finance",
                val_3: "Comunicare onestă",

                prep_title: "Pregătire Interviu", prep_sub: "Stăpânește abilitățile necesare pentru interviu.",
                star_t: "Metoda STAR", star_d: "Întrebări comportamentale.",
                psych_t: "Evaluare Abilități", psych_d: "Logică și raționament.",
                case_t: "Studii de Caz", case_d: "Scenarii reale.",

                test_title: "Validează Nivelul de Engleză", test_desc: "Un nivel certificat este necesar. Fă testul Duolingo online.", btn_test: "Fă Testul Duolingo",

                contact_title: "Contactează-mă", contact_sub: "Alege succesul! Scrie-mi azi.",
                ph_name: "Nume Complet", ph_phone: "Telefon", ph_email: "Email", ph_msg: "Cum te pot ajuta?", btn_send: "Trimite",

                elig_title: "Verifică Eligibilitatea", elig_desc: "Răspunde la întrebări pentru a vedea dacă te califici.", btn_check_elig: "Răspunde",
                lbl_q1: "1. Oraș", lbl_q2: "2. Rezidență", lbl_q3: "3. Nivel Engleză", lbl_q4: "4. Diplomă", lbl_q5: "5. Tip Curs", lbl_q6: "6. Domeniu", lbl_q7: "7. Program", lbl_q8: "8. Vrei în Londra?", 
                link_duolingo_check: "Nu ești sigur de nivel? Fă testul",
                btn_submit_elig: "Trimite Răspunsuri"
            },

            pl: {
                nav_tagline: "Pomożemy Ci znaleźć właściwy kierunek",
                nav_courses: "Kursy", nav_eligibility: "Kwalifikowalność", btn_contact: "Kontakt",
                
                role: "Doradca Studenta i Trener Akademicki",
                hero_slogan: "\"Twoja Przyszłość, Mój Priorytet.\"",
                btn_back: "Powrót",

                search_title: "Szukaj Kursów",
                lbl_postcode: "Miasto", lbl_level: "Poziom", lbl_subject: "Kierunek", btn_find: "Szukaj",

                about_title: "Przekuwamy Ambicje w Osiągnięcia",
                about_sub: "Dedykowane wsparcie w Twojej podróży.",
                bio_p1: "Jako doświadczony Doradca Studenta specjalizuję się w pomocy przy aplikacjach i wsparciu rekrutacyjnym.",
                bio_quote: "\"Stosuję indywidualne podejście, koncentrując się na celach i potencjale każdego studenta.\"",
                values_title: "Dlaczego Ja?",
                val_1: "Zrozumienie wymagań",
                val_2: "Wsparcie finansowe",
                val_3: "Uczciwa komunikacja",

                prep_title: "Przygotowanie do Rozmowy", prep_sub: "Opanuj umiejętności.",
                star_t: "Metoda STAR", star_d: "Pytania behawioralne.",
                psych_t: "Testy Zdolności", psych_d: "Logika.",
                case_t: "Studia Przypadku", case_d: "Scenariusze.",

                test_title: "Sprawdź Angielski", test_desc: "Zrób test Duolingo online.", btn_test: "Zrób Test",

                contact_title: "Skontaktuj się", contact_sub: "Wybierz sukces!",
                ph_name: "Imię i Nazwisko", ph_phone: "Telefon", ph_email: "Email", ph_msg: "Wiadomość", btn_send: "Wyślij",

                elig_title: "Sprawdź Uprawnienia", elig_desc: "Odpowiedz na pytania.", btn_check_elig: "Sprawdź",
                lbl_q1: "1. Miasto", lbl_q2: "2. Status", lbl_q3: "3. Angielski", lbl_q4: "4. Dyplom", lbl_q5: "5. Typ Kursu", lbl_q6: "6. Kierunek", lbl_q7: "7. Harmonogram", lbl_q8: "8. Londyn?", 
                link_duolingo_check: "Sprawdź swój poziom",
                btn_submit_elig: "Wyślij"
            },

            hu: {
                nav_tagline: "Segítünk megtalálni a helyes irányt",
                nav_courses: "Tanfolyamok", nav_eligibility: "Jogosultság", btn_contact: "Kapcsolat",
                
                role: "Diáktanácsadó és Akadémiai Coach",
                hero_slogan: "\"A Jövőd, Az Én Prioritásom.\"",
                btn_back: "Vissza",

                search_title: "Kurzus Keresése",
                lbl_postcode: "Város", lbl_level: "Szint", lbl_subject: "Tárgy", btn_find: "Keresés",

                about_title: "Az Ambíció Megvalósítása",
                about_sub: "Elkötelezett támogatás.",
                bio_p1: "Tapasztalt diáktanácsadóként a jelentkezési útmutatásra és a felvételi támogatásra szakosodtam.",
                bio_quote: "\"Személyre szabott megközelítést alkalmazok, minden diák céljaira összpontosítva.\"",
                values_title: "Miért Én?",
                val_1: "Követelmények ismerete",
                val_2: "Pénzügyi támogatás",
                val_3: "Őszinte kommunikáció",

                prep_title: "Interjú Felkészülés", prep_sub: "Gyakorlás a sikerért.",
                star_t: "STAR Módszer", star_d: "Viselkedés.",
                psych_t: "Képességfelmérés", psych_d: "Logika.",
                case_t: "Esettanulmány", case_d: "Valós példák.",

                test_title: "Angol Teszt", test_desc: "Duolingo online.", btn_test: "Teszt Indítása",

                contact_title: "Kapcsolat", contact_sub: "Írj nekem!",
                ph_name: "Név", ph_phone: "Telefon", ph_email: "Email", ph_msg: "Üzenet", btn_send: "Küldés",

                elig_title: "Jogosultság", elig_desc: "Válaszolj a kérdésekre.", btn_check_elig: "Válaszadás",
                lbl_q1: "1. Város", lbl_q2: "2. Státusz", lbl_q3: "3. Angol", lbl_q4: "4. Diploma", lbl_q5: "5. Típus", lbl_q6: "6. Terület", lbl_q7: "7. Órarend", lbl_q8: "8. London?", 
                link_duolingo_check: "Nem vagy biztos a szintben?",
                btn_submit_elig: "Küldés"
            },

            es: {
                nav_tagline: "Te ayudamos a encontrar el camino",
                nav_courses: "Cursos", nav_eligibility: "Elegibilidad", btn_contact: "Contacto",
                
                role: "Asesor Estudiantil y Coach",
                hero_slogan: "\"Tu Futuro, Mi Prioridad.\"",
                btn_back: "Volver",

                search_title: "Buscar Cursos",
                lbl_postcode: "Ciudad", lbl_level: "Nivel", lbl_subject: "Tema", btn_find: "Buscar",

                about_title: "Convirtiendo Ambición en Logros",
                about_sub: "Apoyo dedicado para tu viaje.",
                bio_p1: "Como asesor experimentado, me especializo en orientación de solicitudes y apoyo de admisión.",
                bio_quote: "\"Adopto un enfoque personalizado, centrándome en los objetivos de cada estudiante.\"",
                values_title: "¿Por qué yo?",
                val_1: "Requisitos claros",
                val_2: "Apoyo financiero",
                val_3: "Comunicación honesta",

                prep_title: "Entrevista", prep_sub: "Preparación completa.",
                star_t: "Método STAR", star_d: "Comportamiento.",
                psych_t: "Habilidad", psych_d: "Lógica.",
                case_t: "Casos Prácticos", case_d: "Escenarios.",

                test_title: "Prueba de Inglés", test_desc: "Duolingo online.", btn_test: "Tomar Test",

                contact_title: "Contáctame", contact_sub: "¡Elige el éxito!",
                ph_name: "Nombre", ph_phone: "Teléfono", ph_email: "Email", ph_msg: "Mensaje", btn_send: "Enviar",

                elig_title: "Elegibilidad", elig_desc: "Responde preguntas.", btn_check_elig: "Responder",
                lbl_q1: "1. Ciudad", lbl_q2: "2. Residencia", lbl_q3: "3. Inglés", lbl_q4: "4. Diploma", lbl_q5: "5. Tipo", lbl_q6: "6. Campo", lbl_q7: "7. Horario", lbl_q8: "8. ¿Londres?", 
                link_duolingo_check: "¿Dudas con el nivel?",
                btn_submit_elig: "Enviar"
            },

            it: {
                nav_tagline: "Ti aiutiamo a trovare la strada giusta",
                nav_courses: "Corsi", nav_eligibility: "Idoneità", btn_contact: "Contatti",
                
                role: "Consulente Studentesco",
                hero_slogan: "\"Il Tuo Futuro, La Mia Priorità.\"",
                btn_back: "Indietro",

                search_title: "Cerca Corsi",
                lbl_postcode: "Città", lbl_level: "Livello", lbl_subject: "Materia", btn_find: "Cerca",

                about_title: "Trasformare l'Ambizione in Successo",
                about_sub: "Supporto dedicato.",
                bio_p1: "In qualità di consulente esperto, sono specializzato nella guida alle domande e nel supporto all'ammissione.",
                bio_quote: "\"Adotto un approccio personalizzato, concentrandomi sugli obiettivi dello studente.\"",
                values_title: "Perché Io?",
                val_1: "Requisiti chiari",
                val_2: "Supporto finanziario",
                val_3: "Comunicazione onesta",

                prep_title: "Colloquio", prep_sub: "Preparazione.",
                star_t: "Metodo STAR", star_d: "Comportamento.",
                psych_t: "Abilità", psych_d: "Logica.",
                case_t: "Casi Studio", case_d: "Scenari.",

                test_title: "Test Inglese", test_desc: "Duolingo online.", btn_test: "Fai Test",

                contact_title: "Contattami", contact_sub: "Scrivimi oggi.",
                ph_name: "Nome", ph_phone: "Telefono", ph_email: "Email", ph_msg: "Messaggio", btn_send: "Invia",

                elig_title: "Idoneità", elig_desc: "Verifica ora.", btn_check_elig: "Rispondi",
                lbl_q1: "1. Città", lbl_q2: "2. Residenza", lbl_q3: "3. Inglese", lbl_q4: "4. Diploma", lbl_q5: "5. Tipo", lbl_q6: "6. Campo", lbl_q7: "7. Orario", lbl_q8: "8. Londra?", 
                link_duolingo_check: "Verifica il tuo livello",
                btn_submit_elig: "Invia"
            },

            pt: {
                nav_tagline: "Ajudamos você a encontrar o caminho",
                nav_courses: "Cursos", nav_eligibility: "Elegibilidade", btn_contact: "Contato",
                
                role: "Consultor Estudantil",
                hero_slogan: "\"O Teu Futuro, A Minha Prioridade.\"",
                btn_back: "Voltar",

                search_title: "Buscar Cursos",
                lbl_postcode: "Cidade", lbl_level: "Nível", lbl_subject: "Assunto", btn_find: "Buscar",

                about_title: "Transformando Ambição em Conquista",
                about_sub: "Apoio dedicado.",
                bio_p1: "Como consultor experiente, especializo-me em orientação de candidaturas e apoio à admissão.",
                bio_quote: "\"Adoto uma abordagem personalizada, focando nos objetivos do aluno.\"",
                values_title: "Porquê Eu?",
                val_1: "Requisitos claros",
                val_2: "Apoio financeiro",
                val_3: "Comunicação honesta",

                prep_title: "Entrevista", prep_sub: "Preparação.",
                star_t: "Método STAR", star_d: "Comportamento.",
                psych_t: "Habilidade", psych_d: "Lógica.",
                case_t: "Casos", case_d: "Cenários.",

                test_title: "Teste Inglês", test_desc: "Duolingo online.", btn_test: "Fazer Teste",

                contact_title: "Contacte-me", contact_sub: "Fale comigo.",
                ph_name: "Nome", ph_phone: "Telefone", ph_email: "Email", ph_msg: "Mensagem", btn_send: "Enviar",

                elig_title: "Elegibilidade", elig_desc: "Verifique agora.", btn_check_elig: "Responder",
                lbl_q1: "1. Cidade", lbl_q2: "2. Residência", lbl_q3: "3. Inglês", lbl_q4: "4. Diploma", lbl_q5: "5. Tipo", lbl_q6: "6. Área", lbl_q7: "7. Horário", lbl_q8: "8. Londres?", 
                link_duolingo_check: "Verificar nível",
                btn_submit_elig: "Enviar"
            },

            el: {
                nav_tagline: "Σας βοηθάμε να βρείτε τη σωστή κατεύθυνση",
                nav_courses: "Μαθήματα", nav_eligibility: "Επιλεξιμότητα", btn_contact: "Επαφή",
                
                role: "Σύμβουλος Φοιτητών",
                hero_slogan: "\"Το Μέλλον Σου, Προτεραιότητά Μου.\"",
                btn_back: "Πίσω",

                search_title: "Αναζήτηση Μαθημάτων",
                lbl_postcode: "Πόλη", lbl_level: "Επίπεδο", lbl_subject: "Θέμα", btn_find: "Εύρεση",

                about_title: "Επιτυχία & Φιλοδοξία",
                about_sub: "Αφιερωμένη υποστήριξη.",
                bio_p1: "Ως έμπειρος Σύμβουλος, ειδικεύομαι στην καθοδήγηση αιτήσεων και την υποστήριξη εισαγωγών.",
                bio_quote: "\"Εστιάζω στους στόχους και τις δυνατότητες κάθε φοιτητή.\"",
                values_title: "Γιατί εγώ;",
                val_1: "Κατανόηση απαιτήσεων",
                val_2: "Οικονομική στήριξη",
                val_3: "Ειλικρίνεια",

                prep_title: "Συνέντευξη", prep_sub: "Προετοιμασία.",
                star_t: "Μέθοδος STAR", star_d: "Συμπεριφορά.",
                psych_t: "Ικανότητες", psych_d: "Λογική.",
                case_t: "Μελέτες", case_d: "Σενάρια.",

                test_title: "Τεστ Αγγλικών", test_desc: "Duolingo online.", btn_test: "Έναρξη",

                contact_title: "Επικοινωνία", contact_sub: "Στείλτε μήνυμα.",
                ph_name: "Όνομα", ph_phone: "Τηλέφωνο", ph_email: "Email", ph_msg: "Μήνυμα", btn_send: "Αποστολή",

                elig_title: "Επιλεξιμότητα", elig_desc: "Έλεγχος.", btn_check_elig: "Απάντηση",
                lbl_q1: "1. Πόλη", lbl_q2: "2. Διαμονή", lbl_q3: "3. Αγγλικά", lbl_q4: "4. Δίπλωμα", lbl_q5: "5. Τύπος", lbl_q6: "6. Πεδίο", lbl_q7: "7. Πρόγραμμα", lbl_q8: "8. Λονδίνο;", 
                link_duolingo_check: "Έλεγχος επιπέδου",
                btn_submit_elig: "Υποβολή"
            },

            bg: {
                nav_tagline: "Ние ви помагаме да намерите посока",
                nav_courses: "Курсове", nav_eligibility: "Допустимост", btn_contact: "Контакт",
                
                role: "Студентски Консултант",
                hero_slogan: "\"Твоето Бъдеще, Мой Приоритет.\"",
                btn_back: "Назад",

                search_title: "Търсене на Курсове",
                lbl_postcode: "Град", lbl_level: "Ниво", lbl_subject: "Тема", btn_find: "Търси",

                about_title: "Превръщане на Амбицията в Успех",
                about_sub: "Специализирана подкрепа.",
                bio_p1: "Като опитен консултант, аз специализирам в насоки за кандидатстване и подкрепа за прием.",
                bio_quote: "\"Фокусирам се върху целите и потенциала на всеки студент.\"",
                values_title: "Защо аз?",
                val_1: "Ясни изисквания",
                val_2: "Финансова подкрепа",
                val_3: "Честност",

                prep_title: "Интервю", prep_sub: "Подготовка.",
                star_t: "Метод STAR", star_d: "Поведение.",
                psych_t: "Умения", psych_d: "Логика.",
                case_t: "Казуси", case_d: "Сценарии.",

                test_title: "Английски Тест", test_desc: "Duolingo онлайн.", btn_test: "Старт",

                contact_title: "Контакт", contact_sub: "Пишете ми.",
                ph_name: "Име", ph_phone: "Телефон", ph_email: "Имейл", ph_msg: "Съобщение", btn_send: "Изпрати",

                elig_title: "Допустимост", elig_desc: "Проверка.", btn_check_elig: "Отговори",
                lbl_q1: "1. Град", lbl_q2: "2. Статут", lbl_q3: "3. Английски", lbl_q4: "4. Диплома", lbl_q5: "5. Тип", lbl_q6: "6. Сфера", lbl_q7: "7. График", lbl_q8: "8. Лондон?", 
                link_duolingo_check: "Проверете нивото си",
                btn_submit_elig: "Изпрати"
            }
        };

        const t = translations[lang] || translations['en'];
        document.querySelectorAll('[data-key]').forEach(el => {
            const k = el.getAttribute('data-key');
            if(t[k]) {
                if(el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') el.placeholder = t[k];
                else el.innerText = t[k];
            }
        });
    }
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof feather !== 'undefined') feather.replace();

        const form = document.getElementById('ovidiu-contact-form');
        const formWrapper = document.getElementById('contact-form-wrapper');
        const successMessage = document.getElementById('success-message');
        const submitBtn = document.getElementById('submit-btn');
        const btnText = document.getElementById('btn-text');
        const btnIcon = document.getElementById('btn-icon');
        const btnSpinner = document.getElementById('btn-spinner');

        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); 
                
                // Loading State
                submitBtn.disabled = true;
                btnText.textContent = "Sending...";
                btnIcon.classList.add('hidden');
                btnSpinner.classList.remove('hidden');

                const formData = new FormData(form);
                const originalMsg = formData.get("message");
                formData.set("message", originalMsg + "\n\n[Ref ID: " + Date.now() + "]");

                fetch("https://api.web3forms.com/submit", {
                    method: "POST",
                    body: formData
                })
                .then(async (response) => {
                    const json = await response.json();
                    if (response.status === 200) {
                        // Success Animation
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
                        alert(json.message);
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
            btnText.textContent = "Send Request";
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
        
        const coursesDB = <?php echo $coursesJson; ?>;
        
        window.handleSearch = function(e) {
            e.preventDefault();
            
            const cityInput = document.getElementById('user-postcode').value.toLowerCase().trim();
            const levelInput = document.getElementById('user-level').value;
            const subjectInput = document.getElementById('user-subject').value;
            
            const div = document.getElementById('results-area');
            const spinner = document.getElementById('loading-spinner');
            
            if(!cityInput) return alert("Please enter a City.");
            
            div.innerHTML = '';
            spinner.classList.remove('hidden');
            
            setTimeout(() => {
                const results = coursesDB.filter(c => {
                    const courseCity = (c.city || "").toLowerCase();
                    const courseAddress = (c.address || "").toLowerCase();
                    const matchCity = courseCity.includes(cityInput) || courseAddress.includes(cityInput);

                    const dbLevel = (c.level || "").toLowerCase();
                    const selLevel = levelInput.toLowerCase();
                    const matchLevel = (levelInput === 'All') || dbLevel.includes(selLevel);

                    const matchSubject = (subjectInput === 'All') || (c.subject === subjectInput);

                    return matchCity && matchLevel && matchSubject;
                });
                
                spinner.classList.add('hidden');

                if(results.length > 0) {
                    results.slice(0, 10).forEach(c => { 
                        div.innerHTML += `
                        <div class="bg-white p-6 rounded-xl border border-slate-100 mb-4 shadow-sm hover:shadow-md transition duration-300 group">
                            <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-[10px] font-bold text-white bg-[#1e3a8a] px-2 py-1 rounded-full uppercase tracking-wide">Accredited</span>
                                         <span class="text-[10px] font-bold text-[#1e3a8a] bg-blue-50 px-2 py-1 rounded-full border border-blue-100">${c.level || 'Degree'}</span>
                                    </div>
                                    <h4 class="font-bold text-lg text-slate-800 group-hover:text-[#1e3a8a] transition">${c.title || c.courses[0] || "Course Title"}</h4>
                                    
                                    <div class="text-xs text-slate-500 mt-3 flex flex-wrap gap-4">
                                        <span class="flex items-center gap-1.5"><i data-feather="map-pin" class="w-3 h-3 text-red-500"></i> ${c.city || cityInput}</span>
                                        <span class="flex items-center gap-1.5"><i data-feather="book-open" class="w-3 h-3 text-blue-500"></i> ${c.subject || 'General'}</span>
                                    </div>
                                </div>
                                
                                <div class="text-right sm:text-right w-full sm:w-auto flex sm:block justify-between items-center border-t sm:border-0 pt-3 sm:pt-0 border-slate-100">
                                    <div>
                                        <span class="block text-lg font-bold text-emerald-600">Course Open</span>
                                        <span class="text-xs text-slate-400 font-medium block mt-0.5">Enrolling Now</span>
                                    </div>
                                    <a href="#contact" class="mt-3 bg-[#1e3a8a] text-white px-5 py-2 rounded-lg text-sm font-bold shadow-md hover:bg-blue-800 transition inline-block text-center sm:ml-4">Apply</a>
                                </div>
                            </div>
                        </div>`;
                    });
                    if (typeof feather !== 'undefined') feather.replace();
                } else {
                    div.innerHTML = `
                    <div class="p-6 bg-white border border-gray-200 rounded-xl text-center text-gray-500">
                        <p class="font-bold">No courses found in "${document.getElementById('user-postcode').value}".</p>
                        <p class="text-sm mt-1">Try searching for a larger nearby city.</p>
                    </div>`;
                }
            }, 600);
        };
    });
</script>
</body>
</html>
