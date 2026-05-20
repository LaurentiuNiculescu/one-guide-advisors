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
    <title>Valentina Constantin | Student Advisor</title>
    
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
            --secondary: #b45309; /* Academic Gold */
            --bg-body: #f8f9fa;
            --text-main: #2d3748;
            --border-color: #e2e8f0;
        }

        body { font-family: 'Lato', sans-serif; color: var(--text-main); background-color: var(--bg-body); overflow-x: hidden; position: relative; }
        h1, h2, h3, .serif-font { font-family: 'Playfair Display', serif; }

        #bg-fixed { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -2; background-image: url('<?php echo get_template_directory_uri(); ?>/images/background.png'); background-position: center center; background-repeat: no-repeat; background-size: cover; }
        #bg-veil { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; background: rgba(255, 255, 255, 0.90); backdrop-filter: blur(2px); }

        nav { background: rgba(255, 255, 255, 0.95); border-bottom: 1px solid var(--border-color); box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .fade-in { animation: fadeIn 0.8s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        .input-standard { background: #f9fafb; border: 1px solid #d1d5db; color: #1f2937; border-radius: 0.5rem; padding: 0.75rem; width: 100%; transition: all 0.2s; }
        .input-standard:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1); outline: none; background: #ffffff; }

        .btn-blue { background-color: var(--primary); color: white; padding: 12px 30px; border-radius: 50px; font-weight: 700; transition: transform 0.2s; display: inline-block; cursor: pointer; text-align: center; }
        .btn-blue:hover { background-color: #172554; transform: translateY(-2px); }
        .btn-outline-blue { background: transparent; border: 2px solid var(--primary); color: var(--primary); padding: 10px 28px; border-radius: 50px; font-weight: 700; transition: all 0.2s; display: inline-block; text-align: center; }
        .btn-outline-blue:hover { background: var(--primary); color: white; }

        .content-card { background: #ffffff; border-radius: 1rem; padding: 2.5rem; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05); border: 1px solid var(--border-color); }
        .prep-card { background: #ffffff; border: 1px solid #e2e8f0; color: var(--primary); padding: 2rem; border-radius: 1rem; transition: transform 0.2s; display: block; text-align: center; height: 100%; }
        .prep-card:hover { transform: translateY(-5px); border-color: var(--secondary); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }

        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; display: none; justify-content: center; align-items: center; padding: 20px; }
        .modal-content { background: white; width: 100%; max-width: 600px; border-radius: 1rem; padding: 30px; position: relative; max-height: 90vh; overflow-y: auto; animation: slideUp 0.3s ease; }
        @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

        #mobile-menu { display: none; position: absolute; top: 100%; left: 0; width: 100%; background: white; border-top: 1px solid #e2e8f0; flex-direction: column; padding: 1rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); z-index: 40; animation: slideDown 0.3s ease-out; }
        #mobile-menu.active { display: flex; }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        
        footer { background: #ffffff; color: var(--text-main); border-top: 1px solid var(--border-color); }
        .footer-socials a { display: inline-flex; align-items: center; justify-content: center; width: 50px; height: 50px; border-radius: 50%; background: #f8fafc; transition: all 0.3s ease; font-size: 1.6rem; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .footer-socials a:hover { transform: translateY(-4px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .icon-fb { color: #1877F2; } .icon-fb:hover { background: #1877F2; color: white; }
        .icon-wa { color: #25D366; } .icon-wa:hover { background: #25D366; color: white; }
        .icon-mail { color: #475569; } .icon-mail:hover { background: #475569; color: white; }
        
        .pagination-btn { padding: 8px 16px; background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 6px; font-weight: 600; color: #334155; transition: all 0.2s; }
        .pagination-btn:hover:not(:disabled) { background: #e2e8f0; color: #0f172a; }
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
                
                <a href="#contact" class="btn-blue shadow-md" data-key="nav_contact">Contact</a>
            </div>

            <button class="md:hidden p-2 text-slate-600 border border-slate-300 rounded-lg hover:bg-slate-100 transition mobile-toggle" onclick="toggleMobileMenu()">
                <i data-feather="menu"></i>
            </button>

            <div id="mobile-menu">
                <a href="#course-search" class="block py-3 font-medium text-gray-600 hover:text-[#1e3a8a]" onclick="toggleMobileMenu()" data-key="nav_courses">Courses</a>
                <a href="#eligibility" class="block py-3 font-medium text-gray-600 hover:text-[#1e3a8a]" onclick="toggleMobileMenu()" data-key="nav_eligibility">Eligibility</a>
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
                <a href="#contact" class="btn-blue w-full mt-4 block text-center" onclick="toggleMobileMenu()" data-key="nav_contact">Contact</a>
            </div>
        </div>
    </nav>

    <main>
        <section class="pt-40 pb-24 px-6 border-b border-gray-100/50">
            <div class="max-w-5xl mx-auto flex flex-col md:flex-row items-center gap-12 fade-in">
                <div class="relative shrink-0">
                    <div class="absolute inset-0 bg-[#1e3a8a] blur-xl opacity-20 rounded-full"></div>
                    <img src="<?php echo get_template_directory_uri(); ?>/images/ValentinaConstantin.jpg" alt="Valentina Constantin" class="relative w-64 h-64 rounded-full border-4 border-white shadow-2xl object-cover">
                </div>
                <div class="text-center md:text-left">
                    <h1 class="text-5xl font-bold text-slate-900 mb-2 serif-font">Valentina Constantin</h1>
                    <p class="text-[#b45309] font-bold tracking-widest uppercase mb-6" data-key="role_title">Student Advisor</p>
                    
                    <div class="flex flex-wrap gap-4 justify-center md:justify-start mb-6">
                        <div class="flex items-center gap-2 text-gray-600 font-medium">
                            <i data-feather="phone" class="w-4 h-4 text-[#1e3a8a]"></i> +44 7846 092002
                        </div>
                        <div class="flex items-center gap-2 text-gray-600 font-medium">
                            <i data-feather="mail" class="w-4 h-4 text-[#1e3a8a]"></i> valentina.constantin@ask33.co.uk
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-4 justify-center md:justify-start">
                        <a href="#contact" class="btn-blue shadow-lg transition" data-key="nav_contact">Get in Touch</a>
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
                    <h2 class="text-3xl font-bold text-slate-900 serif-font" data-key="bio_header">Let’s Make This Simple</h2>
                </div>
                
                <div class="grid lg:grid-cols-2 gap-12">
                    <div class="space-y-6 text-gray-700 text-lg leading-relaxed">
                        <p data-key="bio_text">Thinking about university but not sure where to start? I’m here to help you understand your options and guide you step by step. I work with Ask33 and support students in choosing the right course and completing their applications correctly. I’m calm, patient, and always ready to explain things clearly — no complicated language, no pressure.</p>
                        
                        <div class="bg-[#eff6ff] p-6 rounded-xl border-l-4 border-[#1e3a8a] italic text-slate-800">
                            <p data-key="bio_quote">"You don’t need to know everything before contacting me. We figure it out together."</p>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-8 rounded-2xl border border-gray-200 h-fit shadow-sm">
                        <h4 class="font-bold text-xl text-[#1e3a8a] mb-6" data-key="focus_title">Here’s How I Support You:</h4>
                        <ul class="space-y-4 text-gray-700">
                            <li class="flex items-start gap-3"><i data-feather="check-circle" class="text-[#b45309] mt-1 shrink-0"></i> <span data-key="mission_1">I check your eligibility and help you choose a course that fits you</span></li>
                            <li class="flex items-start gap-3"><i data-feather="check-circle" class="text-[#b45309] mt-1 shrink-0"></i> <span data-key="mission_2">I review your documents carefully and submit your application</span></li>
                            <li class="flex items-start gap-3"><i data-feather="check-circle" class="text-[#b45309] mt-1 shrink-0"></i> <span data-key="mission_3">I prepare you for interviews, tests, and help with Student Finance every year</span></li>
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
                    <h2 class="text-2xl font-bold text-center text-slate-900 mb-4" data-key="form_header">Contact Me</h2>
                    <p class="text-center text-gray-500 mb-8" data-key="form_sub">Everything is 100% free. Ready to start?</p>
                    
                    <form id="valentina-contact-form" action="https://api.web3forms.com/submit" method="POST" class="space-y-5">
                        <input type="hidden" name="access_key" value="<?php echo $web3FormsKey; ?>">
                        <input type="hidden" name="subject" value="Contact for Valentina Constantin">
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
            <button onclick="document.getElementById('eligibility-modal').style.display='none'" class="absolute top-4 right-4 text-gray-500 hover:text-red-500"><i data-feather="x"></i></button>
            <button onclick="closeEligibilityModal()" class="modal-close-btn" style="position: absolute; top: 10px; right: 10px; padding: 10px;">
                <i data-feather="x"></i>
            </button>
            <h3 class="text-xl font-bold mb-4 text-[#1e3a8a]" data-key="elig_title">Eligibility Check</h3>
            
            <form action="https://api.web3forms.com/submit" method="POST">
                <input type="hidden" name="access_key" value="<?php echo $web3FormsKey; ?>">
                <input type="hidden" name="subject" value="New Eligibility Check - Andreea Macxim">
                <input type="hidden" name="from_name" value="Eligibility Form">

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q1">1. City / Town</label>
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
                        <div class="mt-2 text-center"><a href="https://englishtest.duolingo.com/applicants" target="_blank" class="text-blue-600 underline text-xs font-bold hover:text-blue-800" data-key="link_duolingo_check">Not sure about the level of english take this test</a></div>
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
                        <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q7">7. Schedule</label>
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
                        <label class="block text-xs font-bold uppercase mb-1" data-key="lbl_q8">8. London?</label>
                        <select name="london_study" class="input-standard">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full btn-blue" data-key="btn_submit_elig">Submit Answers</button>
                    
                    <button type="button" onclick="closeEligibilityModal()" class="w-full mt-3 text-gray-500 hover:text-gray-700 text-sm font-medium underline">Close</button>
                </div>
            </form>
        </div>
    </div>

    <footer class="bg-white text-gray-700 py-12 text-center mt-12 border-t border-gray-200">
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

        <?php echo "const coursesDB = " . ($coursesJson ?: "[]") . ";"; ?>

        let allSortedResults = [];
        let currentPage = 1;
        const resultsPerPage = 5;

        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            if (menu.style.display === 'flex') {
                menu.style.display = 'none';
            } else {
                menu.style.display = 'flex';
            }
        }

        function toggleSearch() {
            const container = document.getElementById('search-container');
            const btn = document.getElementById('toggle-search-btn');
            if (container.classList.contains('hidden')) {
                container.classList.remove('hidden');
                btn.innerText = "Hide Search";
            } else {
                container.classList.add('hidden');
                btn.innerText = "Show Search";
            }
        }

        function openEligibilityModal() {
            document.getElementById('eligibility-modal').style.display = 'flex';
        }
        function closeEligibilityModal() {
            document.getElementById('eligibility-modal').style.display = 'none';
        }
        
        window.onclick = function(event) {
            const modal = document.getElementById('eligibility-modal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        const form = document.getElementById('andreea-contact-form');
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
                if(btnIcon) btnIcon.classList.add('hidden');
                if(btnSpinner) btnSpinner.classList.remove('hidden');

                const formData = new FormData(form);

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
            if(btnIcon) btnIcon.classList.remove('hidden');
            if(btnSpinner) btnSpinner.classList.add('hidden');
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

        async function handleSearch(e) {
            e.preventDefault();
            const postcode = document.getElementById('user-postcode').value.trim();
            const userLevel = document.getElementById('user-level').value;
            const userSubject = document.getElementById('user-subject').value;
            
            const div = document.getElementById('results-area');
            const spinner = document.getElementById('loading-spinner');
            const pagControls = document.getElementById('pagination-controls');

            if(!postcode) return alert("Enter city or postcode.");
            
            div.innerHTML = '';
            if(pagControls) pagControls.classList.add('hidden');
            if(spinner) spinner.classList.remove('hidden');
            allSortedResults = []; 

            if(coursesDB.length === 0) {
                 for(let i=0; i<15; i++) {
                    coursesDB.push({
                        title: "BA (Hons) Business Management",
                        level: userLevel === 'All' ? 'Undergraduate' : userLevel,
                        subject: userSubject === 'All' ? 'Business' : userSubject,
                        city: postcode.charAt(0).toUpperCase() + postcode.slice(1),
                        institution: "Partner University"
                    });
                }
            }

            // IF MAPS API IS LOADED
            if (typeof google === 'object') {
                const service = new google.maps.DistanceMatrixService();
                
                const chunkSize = 25; 
                const batches = [];
                for (let i = 0; i < coursesDB.length; i += chunkSize) {
                    batches.push(coursesDB.slice(i, i + chunkSize));
                }

                for (const batch of batches) {
                    const destinations = batch.map(c => c.address || c.city);
                    
                    await new Promise(resolve => {
                        service.getDistanceMatrix({
                            origins: [postcode],
                            destinations: destinations,
                            travelMode: 'TRANSIT',
                            unitSystem: google.maps.UnitSystem.METRIC
                        }, (response, status) => {
                            if (status === 'OK') {
                                const rows = response.rows[0].elements;
                                batch.forEach((course, i) => {
                                    if (rows[i].status === "OK") {
                                        const dbLevel = (course.level || "").toLowerCase();
                                        const selLevel = userLevel.toLowerCase();
                                        
                                        const matchLevel = (userLevel === 'All') || 
                                                           (dbLevel.includes(selLevel));

                                        const matchSubject = (userSubject === 'All') || (course.subject === userSubject);

                                        if (matchLevel && matchSubject) {
                                            allSortedResults.push({
                                                ...course,
                                                distValue: rows[i].distance.value,
                                                distText: rows[i].distance.text,
                                                durText: rows[i].duration.text
                                            });
                                        }
                                    }
                                });
                            }
                            resolve();
                        });
                    });
                }

                allSortedResults.sort((a, b) => a.distValue - b.distValue);
                if(spinner) spinner.classList.add('hidden');
                
                if (allSortedResults.length > 0) {
                    currentPage = 1;
                    renderPage(1);
                } else {
                    div.innerHTML = '<div class="p-4 bg-gray-50 border border-gray-200 rounded text-gray-600">No courses found matching criteria. Try different filters.</div>';
                }

            } else {
                // FALLBACK IF API FAILS OR NO KEY
                if(spinner) spinner.classList.add('hidden');
                
                // Simple text-based filter for fallback
                const fallbackResults = coursesDB.filter(c => {
                    const matchCity = (c.city || "").toLowerCase().includes(postcode.toLowerCase());
                    const matchLevel = (userLevel === 'All') || (c.level || "").toLowerCase().includes(userLevel.toLowerCase());
                    const matchSubject = (userSubject === 'All') || (c.subject === userSubject);
                    return matchCity && matchLevel && matchSubject;
                });

                if (fallbackResults.length > 0) {
                    allSortedResults = fallbackResults.map(c => ({...c, durText: "N/A", distText: "N/A"}));
                    currentPage = 1;
                    renderPage(1);
                } else {
                     div.innerHTML = '<div class="p-4 bg-gray-50 border border-gray-200 rounded text-gray-600">No exact matches found in database.</div>';
                }
            }
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
                div.innerHTML += createCourseCard(c, c.durText || "N/A", c.distText || "N/A");
            });

            if (pagControls && indicator && allSortedResults.length > resultsPerPage) {
                pagControls.classList.remove('hidden');
                indicator.innerText = `Page ${page} of ${Math.ceil(allSortedResults.length / resultsPerPage)}`;
            } else if (pagControls) {
                pagControls.classList.add('hidden');
            }
            
            feather.replace();
        }

        function changePage(dir) {
            const totalPages = Math.ceil(allSortedResults.length / resultsPerPage);
            const newPage = currentPage + dir;
            if (newPage > 0 && newPage <= totalPages) {
                currentPage = newPage;
                renderPage(currentPage);
            }
        }

        function createCourseCard(c, duration, distance) {
            return `
            <div class="bg-white p-6 rounded-xl border border-slate-100 mb-4 shadow-sm hover:shadow-md transition duration-300 group">
                <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-[10px] font-bold text-white bg-[#1e3a8a] px-2 py-1 rounded-full uppercase tracking-wide">Accredited</span>
                             <span class="text-[10px] font-bold text-[#1e3a8a] bg-blue-50 px-2 py-1 rounded-full border border-blue-100">${c.level || 'Degree'}</span>
                        </div>
                        <h4 class="font-bold text-lg text-slate-800 group-hover:text-[#1e3a8a] transition">${c.title || c.courses[0] || "Course Title"}</h4>
                        
                        <div class="text-xs text-slate-500 mt-3 flex flex-wrap gap-4">
                            <span class="flex items-center gap-1.5"><i data-feather="map-pin" class="w-3 h-3 text-red-500"></i> ${c.city || 'Campus'}</span>
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
        }


    const translations = {
        en: {
            nav_courses: "Courses", nav_eligibility: "Eligibility", nav_contact: "Contact", role_title: "Student Advisor",
            btn_back: "Back to Team", search_title: "Search Accredited Courses", btn_find: "Find",
            bio_header: "Let’s Make This Simple", 
            bio_text: "Thinking about university but not sure where to start? I’m here to help you understand your options and guide you step by step. I work with Ask33 and support students in choosing the right course and completing their applications correctly. I’m calm, patient, and always ready to explain things clearly — no complicated language, no pressure.",
            bio_quote: "\"You don’t need to know everything before contacting me. We figure it out together.\"",
            focus_title: "Here’s How I Support You:", 
            mission_1: "I check your eligibility and help you choose a course that fits you", 
            mission_2: "I review your documents carefully and submit your application", 
            mission_3: "I prepare you for interviews, tests, and help with Student Finance every year",
            prep_title: "Interview Preparation", prep_sub: "Master the skills needed for your university interview.",
            star_t: "STAR Method", star_d: "Master behavioral questions.", psych_t: "Ability Assessment", psych_d: "Logic & reasoning practice.", case_t: "Case Studies", case_d: "Real-world scenarios.",
            elig_title: "Check Your Eligibility", elig_desc: "Answer a few questions to see if you qualify.", btn_check_elig: "Answer Questions",
            test_title: "Validate Your English", test_desc: "A certified English level is often required for university admission.", btn_test: "Take Test",
            form_header: "Contact Me", form_sub: "Everything is 100% free. Ready to start?", 
            lbl_name: "Full Name", lbl_phone: "Phone Number", lbl_email: "Email Address", ph_msg: "Message", btn_send: "Send Message",
            lbl_q1: "City", lbl_q2: "Residency", lbl_q3: "English", link_duolingo_check: "Not sure? Take test",
            lbl_q4: "Diploma", lbl_q5: "Course Type", lbl_q6: "Field", lbl_q7: "Schedule", lbl_q8: "London?", btn_submit_elig: "Submit Answers",
            lbl_postcode: "City", lbl_mode: "Study Mode", lbl_level: "Level", lbl_subject: "Subject"
        },
        ro: {
            nav_courses: "Cursuri", nav_eligibility: "Eligibilitate", nav_contact: "Contact", role_title: "Consilier Student",
            btn_back: "Înapoi la Echipă", search_title: "Caută Cursuri Acreditate", btn_find: "Caută",
            bio_header: "Să Facem Totul Simplu", 
            bio_text: "Te gândești la facultate, dar nu știi de unde să începi? Sunt aici să te ajut să înțelegi opțiunile și să te ghidez pas cu pas. Lucrez cu Ask33 și sprijin studenții în alegerea cursului potrivit și completarea corectă a aplicațiilor. Sunt o persoană calmă, răbdătoare și gata să explic totul clar — fără limbaj complicat, fără presiune.",
            bio_quote: "\"Nu trebuie să știi totul înainte de a mă contacta. Găsim soluțiile împreună.\"",
            focus_title: "Iată Cum Te Sprijin:", 
            mission_1: "Îți verific eligibilitatea și te ajut să alegi un curs care ți se potrivește", 
            mission_2: "Îți verific documentele cu atenție și îți depun aplicația", 
            mission_3: "Te pregătesc pentru interviuri, teste și te ajut cu Student Finance în fiecare an",
            prep_title: "Pregătire Interviu", prep_sub: "Stăpânește abilitățile necesare pentru interviu.",
            star_t: "Metoda STAR", star_d: "Întrebări comportamentale.", psych_t: "Evaluare Abilități", psych_d: "Logică și raționament.", case_t: "Studii de Caz", case_d: "Scenarii reale.",
            elig_title: "Verifică Eligibilitatea", elig_desc: "Răspunde la câteva întrebări pentru a vedea dacă te califici.", btn_check_elig: "Răspunde la Întrebări",
            test_title: "Validează Engleza", test_desc: "Nivelul de engleză certificat este adesea necesar pentru admitere.", btn_test: "Fă Testul",
            form_header: "Contactează-mă", form_sub: "Totul este 100% gratuit. Gata de start?", 
            lbl_name: "Nume Complet", lbl_phone: "Telefon", lbl_email: "Email", ph_msg: "Mesaj", btn_send: "Trimite",
            lbl_q1: "Oraș", lbl_q2: "Rezidență", lbl_q3: "Engleză", link_duolingo_check: "Nu ești sigur? Fă testul",
            lbl_q4: "Diplomă", lbl_q5: "Tip Curs", lbl_q6: "Domeniu", lbl_q7: "Program", lbl_q8: "Londra?", btn_submit_elig: "Trimite Răspunsuri",
            lbl_postcode: "Oraș", lbl_mode: "Mod Studiu", lbl_level: "Nivel", lbl_subject: "Domeniu"
        },
        pl: {
            nav_courses: "Kursy", nav_eligibility: "Uprawnienia", nav_contact: "Kontakt", role_title: "Doradca Studenta",
            btn_back: "Powrót", search_title: "Szukaj Akredytowanych Kursów", btn_find: "Szukaj",
            bio_header: "Uprośćmy to wszystko", 
            bio_text: "Myślisz o studiach, ale nie wiesz, od czego zacząć? Jestem tutaj, aby pomóc Ci zrozumieć dostępne opcje i poprowadzić Cię krok po kroku. Współpracuję z Ask33 i pomagam studentom w wyborze odpowiedniego kierunku oraz poprawnym wypełnianiu wniosków. Jestem spokojna, cierpliwa i zawsze gotowa wyjaśnić wszystko jasno — bez skomplikowanego języka i bez presji.",
            bio_quote: "\"Nie musisz wiedzieć wszystkiego przed skontaktowaniem się ze mną. Razem znajdziemy rozwiązanie.\"",
            focus_title: "Oto jak Cię wspieram:", 
            mission_1: "Sprawdzam Twoje uprawnienia i pomagam wybrać kierunek dopasowany do Ciebie", 
            mission_2: "Dokładnie sprawdzam Twoje dokumenty i wysyłam wniosek", 
            mission_3: "Przygotowuję Cię do rozmów, testów i co roku pomagam w kwestii Student Finance",
            prep_title: "Przygotowanie do Rozmowy", prep_sub: "Opanuj umiejętności potrzebne do rozmowy rekrutacyjnej.",
            star_t: "Metoda STAR", star_d: "Opanuj pytania behawioralne.", psych_t: "Ocena Umiejętności", psych_d: "Logika i rozumowanie.", case_t: "Studia Przypadku", case_d: "Scenariusze z życia wzięte.",
            elig_title: "Sprawdź Uprawnienia", elig_desc: "Odpowiedz na kilka pytań, aby sprawdzić kwalifikacje.", btn_check_elig: "Odpowiedz na Pytania",
            test_title: "Potwierdź swój Angielski", test_desc: "Certyfikat z angielskiego jest często wymagany przy rekrutacji.", btn_test: "Podejdź do Testu",
            form_header: "Skontaktuj się ze mną", form_sub: "Wszystko jest w 100% bezpłatne. Gotowy, aby zacząć?", 
            lbl_name: "Imię i Nazwisko", lbl_phone: "Numer Telefonu", lbl_email: "Adres Email", ph_msg: "Wiadomość", btn_send: "Wyślij Wiadomość",
            lbl_q1: "Miasto", lbl_q2: "Status", lbl_q3: "Angielski", link_duolingo_check: "Niepewny? Podejdź do testu",
            lbl_q4: "Dyplom", lbl_q5: "Typ Kursu", lbl_q6: "Kierunek", lbl_q7: "Harmonogram", lbl_q8: "Londyn?", btn_submit_elig: "Wyślij Odpowiedzi",
            lbl_postcode: "Miasto", lbl_mode: "Tryb Nauki", lbl_level: "Poziom", lbl_subject: "Kierunek"
        },
        hu: {
            nav_courses: "Tanfolyamok", nav_eligibility: "Jogosultság", nav_contact: "Kapcsolat", role_title: "Diáktanácsadó",
            btn_back: "Vissza", search_title: "Akkreditált Tanfolyamok Keresése", btn_find: "Keresés",
            bio_header: "Tegyük ezt egyszerűvé", 
            bio_text: "Egyetemen gondolkodik, de nem tudja, hol kezdje? Azért vagyok itt, hogy segítsek megérteni a lehetőségeit, és lépésről lépésre vezessen. Az Ask33-mal dolgozom, és támogatom a hallgatókat a megfelelő kurzus kiválasztásában és a jelentkezések helyes kitöltésében. Nyugodt és türelmes vagyok, és mindig kész vagyok világosan elmagyarázni a dolgokat — bonyolult nyelvezet és nyomás nélkül.",
            bio_quote: "\"Nem kell mindent tudnia, mielőtt felveszi velem a kapcsolatot. Együtt kitaláljuk.\"",
            focus_title: "Így támogatom Önt:", 
            mission_1: "Ellenőrzöm a jogosultságát és segítek az Önhöz illő kurzus kiválasztásában", 
            mission_2: "Gondosan átnézem a dokumentumait és benyújtom a jelentkezését", 
            mission_3: "Felkészítem az interjúkra, tesztekre, és minden évben segítek a Student Finance ügyintézésben",
            prep_title: "Interjú Felkészülés", prep_sub: "Sajátítsd el az egyetemi interjúhoz szükséges készségeket.",
            star_t: "STAR Módszer", star_d: "Mesteri válaszok viselkedési kérdésekre.", psych_t: "Képességfelmérés", psych_d: "Logika és érvelés.", case_t: "Esettanulmányok", case_d: "Valós forgatókönyvek.",
            elig_title: "Ellenőrizze jogosultságát", elig_desc: "Válaszoljon néhány kérdésre a minősítéshez.", btn_check_elig: "Válaszadás a kérdésekre",
            test_title: "Igazolja angol tudását", test_desc: "Az egyetemi felvételhez gyakran igazolt angol nyelvtudás szükséges.", btn_test: "Teszt kitöltése",
            form_header: "Kapcsolatfelvétel", form_sub: "Minden 100% -ban ingyenes. Készen áll a kezdésre?", 
            lbl_name: "Teljes Név", lbl_phone: "Telefonszám", lbl_email: "E-mail Cím", ph_msg: "Üzenet", btn_send: "Üzenet Küldése",
            lbl_q1: "Város", lbl_q2: "Státusz", lbl_q3: "Angol", link_duolingo_check: "Nem biztos? Tesztelje le",
            lbl_q4: "Diploma", lbl_q5: "Kurzus Típusa", lbl_q6: "Terület", lbl_q7: "Időbeosztás", lbl_q8: "London?", btn_submit_elig: "Válaszok beküldése",
            lbl_postcode: "Város", lbl_mode: "Tanulási Mód", lbl_level: "Szint", lbl_subject: "Tárgy"
        },
        es: {
            nav_courses: "Cursos", nav_eligibility: "Elegibilidad", nav_contact: "Contacto", role_title: "Asesora Estudiantil",
            btn_back: "Volver", search_title: "Buscar Cursos Acreditados", btn_find: "Buscar",
            bio_header: "Hagámoslo simple", 
            bio_text: "¿Estás pensando en ir a la universidad pero no sabes por dónde empezar? Estoy aquí para ayudarte a entender tus opciones y guiarte paso a paso. Trabajo con Ask33 y apoyo a los estudiantes en la elección del curso adecuado y en completar sus solicitudes correctamente. Soy tranquila, paciente y siempre estoy dispuesta a explicar las cosas con claridad, sin lenguaje complicado y sin presiones.",
            bio_quote: "\"No necesitas saberlo todo antes de contactarme. Lo resolvemos juntos.\"",
            focus_title: "Así es como te apoyo:", 
            mission_1: "Verifico tu elegibilidad y te ayudo a elegir un curso que se adapte a ti", 
            mission_2: "Reviso tus documentos cuidadosamente y presento tu solicitud", 
            mission_3: "Te preparo para entrevistas, exámenes y te ayudo con Student Finance cada año",
            prep_title: "Preparación de Entrevistas", prep_sub: "Domina las habilidades necesarias para tu entrevista universitaria.",
            star_t: "Método STAR", star_d: "Domina las preguntas de comportamiento.", psych_t: "Evaluación de Capacidades", psych_d: "Lógica y razonamiento.", case_t: "Estudios de Caso", case_d: "Escenarios del mundo real.",
            elig_title: "Consulta tu Elegibilidad", elig_desc: "Responde unas preguntas para ver si calificas.", btn_check_elig: "Responder Preguntas",
            test_title: "Valida tu Inglés", test_desc: "A menudo se requiere un nivel de inglés certificado para la admisión.", btn_test: "Tomar Examen",
            form_header: "Contáctame", form_sub: "Todo es 100% gratuito. ¿Listo para empezar?", 
            lbl_name: "Nombre Completo", lbl_phone: "Teléfono", lbl_email: "Correo Electrónico", ph_msg: "Mensaje", btn_send: "Enviar Mensaje",
            lbl_q1: "Ciudad", lbl_q2: "Residencia", lbl_q3: "Inglés", link_duolingo_check: "¿No estás seguro? Haz el test",
            lbl_q4: "Diploma", lbl_q5: "Tipo de Curso", lbl_q6: "Campo", lbl_q7: "Horario", lbl_q8: "¿Londres?", btn_submit_elig: "Enviar Respuestas",
            lbl_postcode: "Ciudad", lbl_mode: "Modo de Estudio", lbl_level: "Nivel", lbl_subject: "Tema"
        },
        it: {
            nav_courses: "Corsi", nav_eligibility: "Idoneità", nav_contact: "Contatti", role_title: "Consulente Studente",
            btn_back: "Indietro", search_title: "Cerca Corsi Accreditati", btn_find: "Cerca",
            bio_header: "Rendiamo tutto semplice", 
            bio_text: "Stai pensando all'università ma non sai da dove iniziare? Sono qui per aiutarti a capire le tue opzioni e guidarti passo dopo passo. Lavoro con Ask33 e supporto gli studenti nella scelta del corso giusto e nella corretta compilazione delle domande. Sono calma, paziente e sempre pronta a spiegare le cose in modo chiaro, senza linguaggi complicati e senza pressioni.",
            bio_quote: "\"Non devi sapere tutto prima di contattarmi. Lo capiremo insieme.\"",
            focus_title: "Ecco come ti supporto:", 
            mission_1: "Verifico la tua idoneità e ti aiuto a scegliere un corso adatto a te", 
            mission_2: "Esamino attentamente i tuoi documenti e invio la tua domanda", 
            mission_3: "Ti preparo per colloqui, test e ti aiuto con lo Student Finance ogni anno",
            prep_title: "Preparazione Colloquio", prep_sub: "Acquisisci le competenze necessarie per il tuo colloquio universitario.",
            star_t: "Metodo STAR", star_d: "Domina le domande comportamentali.", psych_t: "Valutazione Abilità", psych_d: "Logica e ragionamento.", case_t: "Casi Studio", case_d: "Scenari del mondo reale.",
            elig_title: "Verifica Idoneità", elig_desc: "Rispondi ad alcune domande per vedere se sei idoneo.", btn_check_elig: "Rispondi alle Domande",
            test_title: "Convalida il tuo Inglese", test_desc: "Per l'ammissione all'università è spesso richiesto un livello di inglese certificato.", btn_test: "Fai il Test",
            form_header: "Contattami", form_sub: "Tutto è gratuito al 100%. Pronto a iniziare?", 
            lbl_name: "Nome Completo", lbl_phone: "Numero di Telefono", lbl_email: "Indirizzo Email", ph_msg: "Messaggio", btn_send: "Invia Messaggio",
            lbl_q1: "Città", lbl_q2: "Residenza", lbl_q3: "Inglese", link_duolingo_check: "Non sei sicuro? Fai il test",
            lbl_q4: "Diploma", lbl_q5: "Tipo Corso", lbl_q6: "Campo", lbl_q7: "Orario", lbl_q8: "Londra?", btn_submit_elig: "Invia Risposte",
            lbl_postcode: "Città", lbl_mode: "Modalità Studio", lbl_level: "Livello", lbl_subject: "Materia"
        },
        pt: {
            nav_courses: "Cursos", nav_eligibility: "Elegibilidade", nav_contact: "Contato", role_title: "Consultora Estudantil",
            btn_back: "Voltar", search_title: "Buscar Cursos Credenciados", btn_find: "Buscar",
            bio_header: "Vamos tornar isto simples", 
            bio_text: "Está a pensar na universidade, mas não sabe por onde começar? Estou aqui para ajudar a entender as suas opções e guiá-lo passo a passo. Trabalho com a Ask33 e apoio os estudantes na escolha do curso certo e no preenchimento correto das candidaturas. Sou calma, paciente e estou sempre pronta para explicar as coisas com clareza — sem linguagem complicada, sem pressão.",
            bio_quote: "\"Não precisa de saber tudo antes de me contactar. Descobriremos juntos.\"",
            focus_title: "Eis como o apoio:", 
            mission_1: "Verifico a sua elegibilidade e ajudo a escolher um curso adequado a si", 
            mission_2: "Analiso os seus documentos cuidadosamente e submeto a sua candidatura", 
            mission_3: "Preparo-o para entrevistas, testes e ajudo com o Student Finance todos os anos",
            prep_title: "Preparação para Entrevista", prep_sub: "Domine as competências necessárias para a sua entrevista universitária.",
            star_t: "Método STAR", star_d: "Domine as perguntas comportamentais.", psych_t: "Avaliação de Capacidade", psych_d: "Lógica e raciocínio.", case_t: "Estudos de Caso", case_d: "Cenários do mundo real.",
            elig_title: "Verifique sua Elegibilidade", elig_desc: "Responda a algumas perguntas para ver se cumpre os requisitos.", btn_check_elig: "Responder Perguntas",
            test_title: "Valide seu Inglês", test_desc: "É frequentemente exigido um nível de inglês certificado para a admissão na universidade.", btn_test: "Fazer Teste",
            form_header: "Contacte-me", form_sub: "Tudo é 100% gratuito. Pronto para começar?", 
            lbl_name: "Nome Completo", lbl_phone: "Número de Telefone", lbl_email: "Endereço de Email", ph_msg: "Mensagem", btn_send: "Enviar Mensagem",
            lbl_q1: "Cidade", lbl_q2: "Residência", lbl_q3: "Inglês", link_duolingo_check: "Não tem certeza? Faça o teste",
            lbl_q4: "Diploma", lbl_q5: "Tipo de Curso", lbl_q6: "Área", lbl_q7: "Horário", lbl_q8: "Londres?", btn_submit_elig: "Enviar Respostas",
            lbl_postcode: "Cidade", lbl_mode: "Modo de Estudo", lbl_level: "Nível", lbl_subject: "Assunto"
        },
        el: {
            nav_courses: "Μαθήματα", nav_eligibility: "Επιλεξιμότητα", nav_contact: "Επαφή", role_title: "Σύμβουλος Φοιτητών",
            btn_back: "Πίσω", search_title: "Αναζήτηση Πιστοποιημένων Μαθημάτων", btn_find: "Εύρεση",
            bio_header: "Ας το κάνουμε απλό", 
            bio_text: "Σκέφτεστε το πανεπιστήμιο αλλά δεν ξέρετε από πού να ξεκινήσετε; Είμαι εδώ για να σας βοηθήσω να κατανοήσετε τις επιλογές σας και να σας καθοδηγήσω βήμα προς βήμα. Συνεργάζομαι με την Ask33 και υποστηρίζω τους φοιτητές στην επιλογή του σωστού προγράμματος και στη σωστή συμπλήρωση των αιτήσεών τους. Είμαι ήρεμη, υπομονετική και πάντα έτοιμη να εξηγήσω τα πράγματα καθαρά — χωρίς περίπλοκη γλώσσα, χωρίς πίεση.",
            bio_quote: "\"Δεν χρειάζεται να τα ξέρετε όλα πριν επικοινωνήσετε μαζί μου. Θα τα βρούμε μαζί.\"",
            focus_title: "Να πώς σας υποστηρίζω:", 
            mission_1: "Ελέγχω την επιλεξιμότητά σας και σας βοηθώ να επιλέξετε ένα μάθημα που σας ταιριάζει", 
            mission_2: "Ελέγχω τα έγγραφά σας προσεκτικά και υποβάλλω την αίτησή σας", 
            mission_3: "Σας προετοιμάζω για συνεντεύξεις, τεστ και βοηθώ με το Student Finance κάθε χρόνο",
            prep_title: "Προετοιμασία Συνέντευξης", prep_sub: "Κατακτήστε τις απαραίτητες δεξιότητες για την πανεπιστημιακή σας συνέντευξη.",
            star_t: "Μέθοδος STAR", star_d: "Απαντήστε άριστα σε ερωτήσεις συμπεριφοράς.", psych_t: "Αξιολόγηση Ικανοτήτων", psych_d: "Λογική και συλλογισμός.", case_t: "Μελέτες Περίπτωσης", case_d: "Πραγματικά σενάρια.",
            elig_title: "Ελέγξτε την επιλεξιμότητά σας", elig_desc: "Απαντήστε σε μερικές ερωτήσεις για να δείτε αν πληροίτε τις προϋποθέσεις.", btn_check_elig: "Απαντήστε στις Ερωτήσεις",
            test_title: "Πιστοποιήστε τα Αγγλικά σας", test_desc: "Συχνά απαιτείται πιστοποιημένο επίπεδο αγγλικών για την εισαγωγή στο πανεπιστήμιο.", btn_test: "Κάντε το Τεστ",
            form_header: "Επικοινωνήστε μαζί μου", form_sub: "Όλα είναι 100% δωρεάν. Είστε έτοιμοι να ξεκινήσετε;", 
            lbl_name: "Ονοματεπώνυμο", lbl_phone: "Τηλέφωνο", lbl_email: "Email", ph_msg: "Μήνυμα", btn_send: "Αποστολή Μηνύματος",
            lbl_q1: "Πόλη", lbl_q2: "Διαμονή", lbl_q3: "Αγγλικά", link_duolingo_check: "Δεν είστε σίγουροι; Κάντε το τεστ",
            lbl_q4: "Δίπλωμα", lbl_q5: "Τύπος Μαθήματος", lbl_q6: "Πεδίο", lbl_q7: "Πρόγραμμα", lbl_q8: "Λονδίνο;", btn_submit_elig: "Υποβολή Απαντήσεων",
            lbl_postcode: "Πόλη", lbl_level: "Επίπεδο", lbl_subject: "Θέμα"
        },
        bg: {
            nav_courses: "Курсове", nav_eligibility: "Допустимост", nav_contact: "Контакт", role_title: "Студентски Съветник",
            btn_back: "Назад", search_title: "Търσενε на Акредитирани Курсове", btn_find: "Търσι",
            bio_header: "Нека го направим просто", 
            bio_text: "Мислите за университет, но не сте сигурни откъде да започнете? Тук съм, за да ви помогна да разбереτε възможностите си и да ви напътствам стъпка по стъпка. Работя с Ask33 и подкрепям студентите при избора на подходящия курс и правилното попълване на заявленията им. Спокойна съм, търпелива и винаги готова да обясня нещата ясно — без сложен език, без натиск.",
            bio_quote: "\"Не е необходимо да знаете всичко, преди да се свържете с мен. Ще го измислим заедно.\"",
            focus_title: "Ето как ви подкрепям:", 
            mission_1: "Проверявам вашата допустимост и ви помагам да изберете курс, който ви подхожда", 
            mission_2: "Преглеждам внимателно документите ви и подавам вашето заявление", 
            mission_3: "Подготвяμ ви за интервюта, тестове и помагам със Student Finance всяка година",
            prep_title: "Подготовка за Интервю", prep_sub: "Усъвършенствайте нужните умения за вашето университетско интервю.",
            star_t: "Метод STAR", star_d: "Справете се блестящо с поведенчески въпроσι.", psych_t: "Оценка на Способности", psych_d: "Логика и разсъждение.", case_t: "Казуси", case_d: "Реални сценарии.",
            elig_title: "Проверете Вашата Допустимост", elig_desc: "Отговорете на няколко въпроса, за да видите дали отговаряте на условията.", btn_check_elig: "Отговорете на Въпросите",
            test_title: "Валидирайте Вашия Английски", test_desc: "За прием в университет често се изιсква сертифицирано ниво на английски език.", btn_test: "Направете Тест",
            form_header: "Свържете се с мен", form_sub: "Всичко е 100% безплатно. Готови ли сте да започнете?", 
            lbl_name: "Пълно Име", lbl_phone: "Телефонен Номер", lbl_email: "Имейл Адрес", ph_msg: "Съобщение", btn_send: "Изпрати Съобщение",
            lbl_q1: "Град", lbl_q2: "Статут", lbl_q3: "Английски", link_duolingo_check: "Не сте сигурни? Тествайте се",
            lbl_q4: "Диплома", lbl_q5: "Тип Курс", lbl_q6: "Сфера", lbl_q7: "График", lbl_q8: "Лονдон?", btn_submit_elig: "Изпрати Отговори",
            lbl_postcode: "Град", lbl_level: "Ниво", lbl_subject: "Предмет"
        }
    };

    function changeLanguage(lang) {
        const t = translations[lang] || translations['en'];
        document.querySelectorAll('[data-key]').forEach(el => {
            const k = el.getAttribute('data-key');
            if(t[k]) {
                if(el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') el.placeholder = t[k];
                else el.innerHTML = t[k];
            }
        });
    }   
</script>
</body>
</html>
