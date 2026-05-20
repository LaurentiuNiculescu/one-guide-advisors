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
    <title>Alina-Sorina Niculescu | Student Advisor</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    
    <?php if (!empty($googleMapsKey)): ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo htmlspecialchars($googleMapsKey); ?>&libraries=geometry" async defer></script>
    <?php endif; ?>
    
    <style>
        :root {
            --primary: #1e3a8a; 
            --accent: #2563eb;  
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

        .prep-card { background: #ffffff; border: 1px solid #e2e8f0; color: var(--primary); padding: 2rem; border-radius: 1rem; transition: transform 0.2s; cursor: pointer; display: block; text-align: center; }
        .prep-card:hover { transform: translateY(-5px); border-color: var(--primary); box-shadow: 0 10px 20px rgba(30, 58, 138, 0.1); }

        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; display: none; justify-content: center; align-items: center; padding: 20px; }
        .modal-content { background: white; width: 100%; max-width: 600px; border-radius: 1rem; padding: 30px; position: relative; max-height: 90vh; overflow-y: auto; animation: slideUp 0.3s ease; }
        @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

        footer { background: #ffffff; border-top: 1px solid var(--border-color); }
        .footer-socials { gap: 1rem; } 
        .footer-socials a { display: inline-flex; align-items: center; justify-content: center; width: 45px; height: 45px; border-radius: 50%; background: #f1f5f9; transition: 0.3s; font-size: 1.5rem; }
        .footer-socials a:hover { transform: translateY(-3px); }
        .icon-mail { color: #64748b; } .icon-mail:hover { background: #64748b; color: white; }

        #mobile-menu { display: none; flex-direction: column; width: 100%; background: white; position: absolute; top: 100%; left: 0; z-index: 50; border-top: 1px solid #e2e8f0; padding: 1rem; }
        .fade-in { animation: fadeIn 0.8s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

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
                    <img src="<?php echo get_template_directory_uri(); ?>/images/AlinaSorinaNiculescu.jpg" alt="Alina-Sorina Niculescu" class="relative w-64 h-64 rounded-full border-4 border-white shadow-2xl object-cover">
                </div>
                <div class="text-center md:text-left">
                    <h1 class="text-5xl font-bold text-slate-900 mb-2 serif-font">Alina-Sorina Niculescu</h1>
                    <p class="font-bold tracking-widest uppercase mb-6" style="color: #ff7f7f;" data-key="role_title">Academic Guidance & Support</p>
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
                    <h2 class="text-3xl font-bold text-slate-900 serif-font" data-key="about_title">Dedicated to Your Success</h2>
                    <p class="text-slate-500 mt-2" data-key="about_sub">Student Advisor</p>
                </div>
                <div class="grid lg:grid-cols-2 gap-12">
                    <div class="space-y-6 text-gray-700 text-lg leading-relaxed">
                        <p data-key="bio_p1">I am Alina-Sorina Niculescu, your dedicated Student Advisor. I am committed to offering support and guidance to students throughout their academic journey. My main objective is to help every student reach their maximum potential.</p>
                        <div class="bg-[#eff6ff] p-6 rounded-xl border-l-4 border-[#1e3a8a] italic text-slate-800">
                            <p data-key="bio_quote">"My goal is to be a trusted partner in every student's academic journey, ensuring they have all the necessary resources to succeed."</p>
                        </div>
                        <p data-key="bio_p2">I understand that student life can be challenging. I am here to listen and offer support in difficult moments, ensuring you stay motivated.</p>
                    </div>
                    <div class="bg-gray-50 p-8 rounded-2xl border border-gray-200 h-fit shadow-sm">
                        <h4 class="font-bold text-xl text-[#1e3a8a] mb-6" data-key="offer_title">How I Can Help You:</h4>
                        <ul class="space-y-4 text-gray-700">
                            <li class="flex items-center gap-3 bg-white p-3 rounded shadow-sm"><i data-feather="check-circle" class="text-[#2563eb]"></i> <span data-key="list_1">Academic Counseling & Planning</span></li>
                            <li class="flex items-center gap-3 bg-white p-3 rounded shadow-sm"><i data-feather="check-circle" class="text-[#2563eb]"></i> <span data-key="list_2">Emotional Support</span></li>
                            <li class="flex items-center gap-3 bg-white p-3 rounded shadow-sm"><i data-feather="check-circle" class="text-[#2563eb]"></i> <span data-key="list_3">Resources & Opportunities</span></li>
                            <li class="flex items-center gap-3 bg-white p-3 rounded shadow-sm"><i data-feather="check-circle" class="text-[#2563eb]"></i> <span data-key="list_4">Personalized Planning</span></li>
                            <li class="flex items-center gap-3 bg-white p-3 rounded shadow-sm"><i data-feather="check-circle" class="text-[#2563eb]"></i> <span data-key="list_5">Career Orientation</span></li>
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
            <div class="max-w-xl mx-auto content-card">
                <h2 class="text-2xl font-bold text-center text-slate-900 mb-4" data-key="contact_title">Start Your Journey</h2>
                <p class="text-center text-gray-500 mb-8" data-key="contact_sub">Fill in the form below for guidance on your academic journey.</p>
                
                <form action="https://api.web3forms.com/submit" method="POST">
                    <input type="hidden" name="access_key" value="<?php echo $web3FormsKey; ?>">
                    <input type="checkbox" name="botcheck" class="hidden" style="display: none;">
                    <input type="hidden" name="subject" value="New Contact for Alina-Sorina Niculescu">
                    <input type="hidden" name="from_name" value="One Guide Profile">

                    <div class="space-y-5">
                        <input type="text" name="name" class="input-standard" data-key="lbl_name" placeholder="Full Name" required>
                        <input type="tel" name="phone" class="input-standard" data-key="lbl_phone" placeholder="Phone Number" required>
                        <input type="email" name="email" class="input-standard" data-key="lbl_email" placeholder="Email Address" required>
                        <textarea name="message" rows="4" class="input-standard" data-key="lbl_msg" placeholder="How can I help?" required></textarea>
                        <button type="submit" class="w-full btn-blue" data-key="btn_send">Send Request</button>
                    </div>
                </form>
            </div>
        </section>

    </main>

    <div id="eligibility-modal" class="modal-overlay">
        <div class="modal-content">
            <button onclick="closeEligibilityModal()" class="absolute top-4 right-4 text-gray-500 hover:text-red-500"><i data-feather="x"></i></button>
            <h3 class="text-xl font-bold mb-4 text-[#1e3a8a]">Eligibility Check</h3>
            
            <form action="https://api.web3forms.com/submit" method="POST">
                <input type="hidden" name="access_key" value="<?php echo $web3FormsKey; ?>">
                <input type="hidden" name="subject" value="New Eligibility Check - Alina-Sorina Niculescu">
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
        
        const postcode = document.getElementById('user-postcode').value.trim().toLowerCase();
        const userLevel = document.getElementById('user-level').value;
        const userSubject = document.getElementById('user-subject').value;
        
        const div = document.getElementById('results-area');
        const spinner = document.getElementById('loading-spinner');
        const pagControls = document.getElementById('pagination-controls');

        if(!postcode) return alert("Please enter a Postcode or City.");

        div.innerHTML = '';
        spinner.classList.remove('hidden');
        if(pagControls) pagControls.classList.add('hidden');
        allSortedResults = []; 

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
                        travelMode: google.maps.TravelMode.DRIVING,
                        unitSystem: google.maps.UnitSystem.METRIC
                    }, (response, status) => {
                        if (status === 'OK') {
                            const rows = response.rows[0].elements;
                            
                            batch.forEach((course, i) => {
                                if (rows[i].status === "OK") {
                                    const dbLevel = (course.level || "").toLowerCase();
                                    const selLevel = userLevel.toLowerCase();
                                    const matchLevel = (userLevel === 'All') || 
                                                       (dbLevel.includes(selLevel)) || 
                                                       (selLevel === "year 1" && dbLevel.includes("level 4")) ||
                                                       (selLevel === "year 2" && dbLevel.includes("level 5")) ||
                                                       (selLevel === "top-up" && dbLevel.includes("level 6")) ||
                                                       (selLevel === "master" && (dbLevel.includes("master") || dbLevel.includes("level 7")));

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
            spinner.classList.add('hidden');
            
            if (allSortedResults.length > 0) {
                currentPage = 1;
                renderPage(1);
            } else {
                div.innerHTML = '<div class="p-6 bg-white border border-gray-200 rounded-xl text-center text-gray-500">No courses found matching your criteria.</div>';
            }

        } else {
            // Fallback filtering without Google Maps
            const lowerPostcode = postcode.toLowerCase();
            allSortedResults = coursesDB.filter(c => {
                const cityMatch = (c.city || "").toLowerCase().includes(lowerPostcode) || (c.address || "").toLowerCase().includes(lowerPostcode);
                
                const dbLevel = (c.level || "").toLowerCase();
                const selLevel = userLevel.toLowerCase();
                const matchLevel = (userLevel === 'All') || dbLevel.includes(selLevel);
                
                const matchSubject = (userSubject === 'All') || (c.subject === userSubject);
                
                return cityMatch && matchLevel && matchSubject;
            });

            spinner.classList.add('hidden');
            if (allSortedResults.length > 0) {
                currentPage = 1;
                renderPage(1);
            } else {
                div.innerHTML = '<div class="p-6 bg-white border border-gray-200 rounded-xl text-center text-gray-500">No courses found matching your criteria.</div>';
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

    const translations = {
        en: {
            nav_courses: "Courses", nav_eligibility: "Eligibility", nav_contact: "Contact", 
            nav_tagline: "We help you find the right direction",
            
            // Hero
            role_title: "Academic Guidance & Support",
            hero_slogan: "\"Guiding you through the academic maze with clarity and confidence.\"",
            btn_contact: "Get in Touch", btn_back: "Back to Team",

            // Search
            search_title: "Search Accredited Courses", btn_find: "Find",
            lbl_postcode: "Postcode / City", lbl_level: "Level", lbl_subject: "Subject", lbl_travel: "Travel",

            // Bio (Alina Specific)
            about_title: "Dedicated to Your Success", about_sub: "Student Advisor",
            bio_p1: "I am Alina-Sorina Niculescu, your dedicated Student Advisor. I am committed to offering support and guidance to students throughout their academic journey. My main objective is to help every student reach their maximum potential.",
            bio_quote: "\"My goal is to be a trusted partner in every student's academic journey, ensuring they have all the necessary resources to succeed.\"",
            bio_p2: "I understand that student life can be challenging. I am here to listen and offer support in difficult moments, ensuring you stay motivated.",
            
            // Offer List
            offer_title: "How I Can Help You:",
            list_1: "Academic Counseling & Planning", 
            list_2: "Emotional Support", 
            list_3: "Resources & Opportunities", 
            list_4: "Personalized Planning", 
            list_5: "Career Orientation",

            // Prep
            prep_title: "Interview Preparation", prep_sub: "Master the skills needed for your university interview.",
            star_t: "STAR Method", star_d: "Master behavioral questions.",
            psych_t: "Ability Assessment", psych_d: "Logic & reasoning practice.",
            case_t: "Case Studies", case_d: "Real-world scenarios.",

            // Eligibility
            elig_title: "Check Your Eligibility", elig_desc: "Answer a few questions to see if you qualify for Student Finance.", btn_check_elig: "Answer Questions",
            lbl_q1: "1. City / Town", lbl_q2: "2. Residency Status", lbl_q3: "3. English Level", link_duolingo_check: "Not sure about the level of english take this test",
            lbl_q4: "4. Diploma?", lbl_q5: "5. Course Type", lbl_q6: "6. Field of Study", lbl_q7: "7. Schedule", lbl_q8: "8. London?", btn_submit_elig: "Submit Answers",

            // Test & Contact
            test_title: "Validate Your English Proficiency", test_desc: "Take the official Duolingo English Test online.", btn_test: "Take Duolingo Test",
            contact_title: "Start Your Journey", contact_sub: "Fill in the form below for guidance on your academic journey.",
            form_header: "Start Your Journey", 
            lbl_name: "Full Name", lbl_phone: "Phone Number", lbl_email: "Email Address", lbl_msg: "How can I help?", btn_send: "Send Request"
        },

        ro: {
            nav_courses: "Cursuri", nav_eligibility: "Eligibilitate", nav_contact: "Contact", 
            nav_tagline: "Te ajutăm să găsești direcția potrivită",
            role_title: "Ghidare & Suport Academic",
            hero_slogan: "\"Te ghidez prin labirintul academic cu claritate și încredere.\"",
            btn_contact: "Contactează-mă", btn_back: "Înapoi la Echipă",

            search_title: "Caută Cursuri Acreditate", btn_find: "Caută",
            lbl_postcode: "Cod Poștal / Oraș", lbl_level: "Nivel", lbl_subject: "Subiect", lbl_travel: "Transport",

            about_title: "Dedicat Succesului Tău", about_sub: "Consilier Student",
            bio_p1: "Sunt Alina-Sorina Niculescu, consilierul tău studentesc dedicat. Sunt dedicată să ofer suport și îndrumare studenților în parcursul lor academic. Obiectivul meu principal este să ajut fiecare student să-și atingă potențialul maxim.",
            bio_quote: "\"Scopul meu este să fiu un partener de încredere în călătoria academică, asigurând resursele necesare succesului.\"",
            bio_p2: "Înțeleg provocările vieții de student. Sunt aici să ascult și să ofer sprijin în momentele dificile, asigurându-mă că rămâi motivat.",
            
            offer_title: "Cum te pot ajuta:",
            list_1: "Consiliere Academică", 
            list_2: "Sprijin Emoțional", 
            list_3: "Resurse și Oportunități", 
            list_4: "Planificare Personalizată", 
            list_5: "Orientare în Carieră",

            prep_title: "Pregătire Interviu", prep_sub: "Stăpânește abilitățile necesare.",
            star_t: "Metoda STAR", star_d: "Întrebări comportamentale.",
            psych_t: "Evaluare Abilități", psych_d: "Logică și raționament.",
            case_t: "Studii de Caz", case_d: "Scenarii reale.",

            elig_title: "Verifică Eligibilitatea", elig_desc: "Răspunde la întrebări pentru a vedea dacă te califici.", btn_check_elig: "Verifică Acum",
            lbl_q1: "1. Oraș", lbl_q2: "2. Statut Rezidență", lbl_q3: "3. Nivel Engleză", link_duolingo_check: "Nu ești sigur? Fă testul",
            lbl_q4: "4. Diplomă", lbl_q5: "5. Tip Curs", lbl_q6: "6. Domeniu", lbl_q7: "7. Program", lbl_q8: "8. Londra?", btn_submit_elig: "Trimite",

            test_title: "Validează Engleza", test_desc: "Susține testul oficial Duolingo online.", btn_test: "Fă Testul",
            contact_title: "Începe Călătoria", contact_sub: "Completează formularul de mai jos.",
            form_header: "Începe Călătoria", 
            lbl_name: "Nume Complet", lbl_phone: "Telefon", lbl_email: "Email", lbl_msg: "Cum te pot ajuta?", btn_send: "Trimite Cerere"
        },

        pl: {
            nav_courses: "Kursy", nav_eligibility: "Kwalifikowalność", nav_contact: "Kontakt", 
            nav_tagline: "Pomożemy Ci znaleźć właściwy kierunek",
            role_title: "Wsparcie Akademickie",
            hero_slogan: "\"Prowadzę Cię przez labirynt akademicki z jasnością i pewnością.\"",
            btn_contact: "Skontaktuj się", btn_back: "Powrót",

            search_title: "Szukaj Kursów", btn_find: "Szukaj",
            lbl_postcode: "Kod / Miasto", lbl_level: "Poziom", lbl_subject: "Kierunek", lbl_travel: "Dojazd",

            about_title: "Dedykowany Twojemu Sukcesowi", about_sub: "Doradca Studenta",
            bio_p1: "Jestem Alina-Sorina Niculescu, Twój oddany doradca studenta. Angażuję się w oferowanie wsparcia i wskazówek studentom podczas ich podróży akademickiej. Moim głównym celem jest pomoc każdemu studentowi w osiągnięciu pełnego potencjału.",
            bio_quote: "\"Moim celem jest być zaufanym partnerem w podróży akademickiej każdego studenta, zapewniając niezbędne zasoby do sukcesu.\"",
            bio_p2: "Rozumiem wyzwania życia studenckiego. Jestem tu, aby słuchać i wspierać w trudnych chwilach.",
            
            offer_title: "Jak mogę pomóc:",
            list_1: "Doradztwo Akademickie", 
            list_2: "Wsparcie Emocjonalne", 
            list_3: "Zasoby i Możliwości", 
            list_4: "Planowanie Indywidualne", 
            list_5: "Orientacja Zawodowa",

            prep_title: "Przygotowanie do Rozmowy", prep_sub: "Opanuj umiejętności.",
            star_t: "Metoda STAR", star_d: "Pytania behawioralne.",
            psych_t: "Ocena Umiejętności", psych_d: "Logika i rozumowanie.",
            case_t: "Studium Przypadku", case_d: "Scenariusze.",

            elig_title: "Sprawdź Kwalifikowalność", elig_desc: "Odpowiedz na pytania.", btn_check_elig: "Sprawdź",
            lbl_q1: "1. Miasto", lbl_q2: "2. Status", lbl_q3: "3. Angielski", link_duolingo_check: "Niepewny? Test",
            lbl_q4: "4. Dyplom", lbl_q5: "5. Typ", lbl_q6: "6. Kierunek", lbl_q7: "7. Harmonogram", lbl_q8: "8. Londyn?", btn_submit_elig: "Wyślij",

            test_title: "Potwierdź Angielski", test_desc: "Zrób test Duolingo online.", btn_test: "Zrób Test",
            contact_title: "Rozpocznij Podróż", contact_sub: "Wypełnij formularz poniżej.",
            form_header: "Rozpocznij Podróż", 
            lbl_name: "Imię i Nazwisko", lbl_phone: "Telefon", lbl_email: "Email", lbl_msg: "Jak mogę pomóc?", btn_send: "Wyślij"
        },

        hu: {
            nav_courses: "Tanfolyamok", nav_eligibility: "Jogosultság", nav_contact: "Kapcsolat", 
            nav_tagline: "Segítünk megtalálni a helyes irányt",
            role_title: "Akadémiai Támogatás",
            hero_slogan: "\"Világosan és magabiztosan vezetlek át az akadémiai útvesztőn.\"",
            btn_contact: "Kapcsolat", btn_back: "Vissza",

            search_title: "Keresés", btn_find: "Keresés",
            lbl_postcode: "Város", lbl_level: "Szint", lbl_subject: "Tárgy", lbl_travel: "Utazás",

            about_title: "Elkötelezve a Sikeredért", about_sub: "Diáktanácsadó",
            bio_p1: "Alina-Sorina Niculescu vagyok, az Ön elkötelezett diáktanácsadója. Elköteleztem magam a diákok támogatása és útmutatása mellett akadémiai útjuk során. Fő célom, hogy segítsek minden diáknak elérni maximális potenciálját.",
            bio_quote: "\"Célom, hogy megbízható partner legyek minden diák akadémiai útján, biztosítva a sikerhez szükséges erőforrásokat.\"",
            bio_p2: "Megértem a diákélet kihívásait. Itt vagyok, hogy meghallgassam és támogassam a nehéz pillanatokban.",
            
            offer_title: "Hogyan segíthetek:",
            list_1: "Akadémiai Tanácsadás", 
            list_2: "Érzelmi Támogatás", 
            list_3: "Lehetőségek", 
            list_4: "Személyre Szabott Tervezés", 
            list_5: "Karrier Orientáció",

            prep_title: "Interjú Felkészülés", prep_sub: "Sajátítsd el a készségeket.",
            star_t: "STAR Módszer", star_d: "Viselkedési kérdések.",
            psych_t: "Képességfelmérés", psych_d: "Logika.",
            case_t: "Esettanulmány", case_d: "Forgatókönyvek.",

            elig_title: "Jogosultság Ellenőrzése", elig_desc: "Válaszolj a kérdésekre.", btn_check_elig: "Válaszadás",
            lbl_q1: "1. Város", lbl_q2: "2. Státusz", lbl_q3: "3. Angol", link_duolingo_check: "Teszt",
            lbl_q4: "4. Diploma", lbl_q5: "5. Típus", lbl_q6: "6. Terület", lbl_q7: "7. Idő", lbl_q8: "8. London?", btn_submit_elig: "Küldés",

            test_title: "Igazold Angol Tudásod", test_desc: "Végezd el a tesztet online.", btn_test: "Teszt Indítása",
            contact_title: "Kezdje el Útját", contact_sub: "Töltse ki az űrlapot.",
            form_header: "Kezdje el Útját", 
            lbl_name: "Név", lbl_phone: "Telefon", lbl_email: "Email", lbl_msg: "Miben segíthetek?", btn_send: "Küldés"
        },

        es: {
            nav_courses: "Cursos", nav_eligibility: "Elegibilidad", nav_contact: "Contacto", 
            nav_tagline: "Te ayudamos a encontrar el camino correcto",
            role_title: "Apoyo y Orientación Académica",
            hero_slogan: "\"Guiándote por el laberinto académico con claridad y confianza.\"",
            btn_contact: "Contactar", btn_back: "Volver",

            search_title: "Buscar Cursos", btn_find: "Buscar",
            lbl_postcode: "Ciudad", lbl_level: "Nivel", lbl_subject: "Tema", lbl_travel: "Viaje",

            about_title: "Dedicado a tu Éxito", about_sub: "Asesora Estudiantil",
            bio_p1: "Soy Alina-Sorina Niculescu, tu asesora estudiantil dedicada. Estoy comprometida a ofrecer apoyo y orientación a los estudiantes a lo largo de su viaje académico. Mi objetivo principal es ayudar a cada estudiante a alcanzar su máximo potencial.",
            bio_quote: "\"Mi objetivo es ser un socio confiable en el viaje académico de cada estudiante, asegurando que tengan los recursos necesarios.\"",
            bio_p2: "Entiendo los desafíos de la vida estudiantil. Estoy aquí para escuchar y ofrecer apoyo en momentos difíciles.",
            
            offer_title: "Cómo puedo ayudar:",
            list_1: "Asesoramiento Académico", 
            list_2: "Apoyo Emocional", 
            list_3: "Recursos y Oportunidades", 
            list_4: "Planificación Personalizada", 
            list_5: "Orientación Profesional",

            prep_title: "Preparación Entrevista", prep_sub: "Domina la entrevista.",
            star_t: "Método STAR", star_d: "Comportamiento.",
            psych_t: "Evaluación de Capacidad", psych_d: "Lógica.",
            case_t: "Casos", case_d: "Escenarios.",

            elig_title: "Verificar Elegibilidad", elig_desc: "Responde preguntas.", btn_check_elig: "Verificar",
            lbl_q1: "1. Ciudad", lbl_q2: "2. Estado", lbl_q3: "3. Inglés", link_duolingo_check: "Test",
            lbl_q4: "4. Diploma", lbl_q5: "5. Tipo", lbl_q6: "6. Campo", lbl_q7: "7. Horario", lbl_q8: "8. ¿Londres?", btn_submit_elig: "Enviar",

            test_title: "Valida tu Inglés", test_desc: "Haz el examen online.", btn_test: "Tomar Test",
            contact_title: "Comienza tu Viaje", contact_sub: "Rellena el formulario.",
            form_header: "Comienza tu Viaje", 
            lbl_name: "Nombre", lbl_phone: "Teléfono", lbl_email: "Email", lbl_msg: "¿Cómo ayudo?", btn_send: "Enviar"
        },

        it: {
            nav_courses: "Corsi", nav_eligibility: "Idoneità", nav_contact: "Contatti", 
            nav_tagline: "Ti aiutiamo a trovare la giusta direzione",
            role_title: "Guida e Supporto Accademico",
            hero_slogan: "\"Guidandoti nel labirinto accademico con chiarezza e fiducia.\"",
            btn_contact: "Contattami", btn_back: "Indietro",

            search_title: "Cerca Corsi", btn_find: "Cerca",
            lbl_postcode: "Città", lbl_level: "Livello", lbl_subject: "Materia", lbl_travel: "Viaggio",

            about_title: "Dedicato al Tuo Successo", about_sub: "Consulente Studentesco",
            bio_p1: "Sono Alina-Sorina Niculescu, la tua consulente studentesca dedicata. Mi impegno a offrire supporto e guida agli studenti durante il loro percorso accademico. Il mio obiettivo principale è aiutare ogni studente a raggiungere il suo massimo potenziale.",
            bio_quote: "\"Il mio obiettivo è essere un partner fidato nel percorso accademico di ogni studente, garantendo le risorse necessarie.\"",
            bio_p2: "Capisco le sfide della vita studentesca. Sono qui per ascoltare e offrire supporto nei momenti difficili.",
            
            offer_title: "Come posso aiutarti:",
            list_1: "Consulenza Accademica", 
            list_2: "Supporto Emotivo", 
            list_3: "Risorse e Opportunità", 
            list_4: "Pianificazione Personalizzata", 
            list_5: "Orientamento alla Carriera",

            prep_title: "Preparazione Colloquio", prep_sub: "Migliora le abilità.",
            star_t: "Metodo STAR", star_d: "Comportamentale.",
            psych_t: "Valutazione Abilità", psych_d: "Logica.",
            case_t: "Casi Studio", case_d: "Scenari.",

            elig_title: "Verifica Idoneità", elig_desc: "Rispondi alle domande.", btn_check_elig: "Verifica",
            lbl_q1: "1. Città", lbl_q2: "2. Stato", lbl_q3: "3. Inglese", link_duolingo_check: "Test",
            lbl_q4: "4. Diploma", lbl_q5: "5. Tipo", lbl_q6: "6. Campo", lbl_q7: "7. Orario", lbl_q8: "8. Londra?", btn_submit_elig: "Invia",

            test_title: "Convalida Inglese", test_desc: "Fai il test online.", btn_test: "Fai Test",
            contact_title: "Inizia il Viaggio", contact_sub: "Compila il modulo.",
            form_header: "Inizia il Viaggio", 
            lbl_name: "Nome", lbl_phone: "Telefono", lbl_email: "Email", lbl_msg: "Messaggio", btn_send: "Invia"
        },

        pt: {
            nav_courses: "Cursos", nav_eligibility: "Elegibilidade", nav_contact: "Contato", 
            nav_tagline: "Ajudamos você a encontrar a direção certa",
            role_title: "Orientação e Apoio Acadêmico",
            hero_slogan: "\"Guiando você pelo labirinto acadêmico com clareza e confiança.\"",
            btn_contact: "Contato", btn_back: "Voltar",

            search_title: "Buscar Cursos", btn_find: "Buscar",
            lbl_postcode: "Cidade", lbl_level: "Nível", lbl_subject: "Assunto", lbl_travel: "Viagem",

            about_title: "Dedicado ao Seu Sucesso", about_sub: "Consultora Estudantil",
            bio_p1: "Sou Alina-Sorina Niculescu, sua consultora estudantil dedicada. Estou empenhada em oferecer apoio e orientação aos alunos ao longo de sua jornada acadêmica. Meu principal objetivo é ajudar cada aluno a atingir seu potencial máximo.",
            bio_quote: "\"Meu objetivo é ser um parceiro de confiança na jornada acadêmica de cada aluno, garantindo os recursos necessários.\"",
            bio_p2: "Entendo os desafios da vida estudantil. Estou aqui para ouvir e oferecer apoio nos momentos difíceis.",
            
            offer_title: "Como posso ajudar:",
            list_1: "Aconselhamento Acadêmico", 
            list_2: "Apoio Emocional", 
            list_3: "Recursos e Oportunidades", 
            list_4: "Planejamento Personalizado", 
            list_5: "Orientação de Carreira",

            prep_title: "Preparação Entrevista", prep_sub: "Domine a entrevista.",
            star_t: "Método STAR", star_d: "Comportamental.",
            psych_t: "Avaliação de Capacidade", psych_d: "Lógica.",
            case_t: "Estudos de Caso", case_d: "Cenários.",

            elig_title: "Verificar Elegibilidade", elig_desc: "Responda perguntas.", btn_check_elig: "Verificar",
            lbl_q1: "1. Cidade", lbl_q2: "2. Estado", lbl_q3: "3. Inglês", link_duolingo_check: "Teste",
            lbl_q4: "4. Diploma", lbl_q5: "5. Tipo", lbl_q6: "6. Área", lbl_q7: "7. Horário", lbl_q8: "8. Londres?", btn_submit_elig: "Enviar",

            test_title: "Valide seu Inglês", test_desc: "Faça o teste online.", btn_test: "Fazer Teste",
            contact_title: "Comece Sua Jornada", contact_sub: "Preencha o formulário.",
            form_header: "Comece Sua Jornada", 
            lbl_name: "Nome", lbl_phone: "Telefone", lbl_email: "Email", lbl_msg: "Mensagem", btn_send: "Enviar"
        },

        el: {
            nav_courses: "Μαθήματα", nav_eligibility: "Επιλεξιμότητα", nav_contact: "Επαφή", 
            nav_tagline: "Σας βοηθάμε να βρείτε τη σωστή κατεύθυνση",
            role_title: "Ακαδημαϊκή Καθοδήγηση",
            hero_slogan: "\"Καθοδήγηση με σαφήνεια και εμπιστοσύνη.\"",
            btn_contact: "Επικοινωνία", btn_back: "Πίσω",

            search_title: "Αναζήτηση", btn_find: "Εύρεση",
            lbl_postcode: "Πόλη", lbl_level: "Επίπεδο", lbl_subject: "Θέμα", lbl_travel: "Ταξίδι",

            about_title: "Αφιερωμένη στην Επιτυχία Σας", about_sub: "Σύμβουλος Φοιτητών",
            bio_p1: "Είμαι η Alina-Sorina Niculescu, η αφοσιωμένη Σύμβουλος Φοιτητών σας. Δεσμεύομαι να προσφέρω υποστήριξη και καθοδήγηση στους φοιτητές σε όλη την ακαδημαϊκή τους πορεία. Κύριος στόχος μου είναι να βοηθήσω κάθε μαθητή να φτάσει στο μέγιστο των δυνατοτήτων του.",
            bio_quote: "\"Στόχος μου είναι να είμαι ένας έμπιστος συνεργάτης στο ακαδημαϊκό ταξίδι κάθε φοιτητή.\"",
            bio_p2: "Καταλαβαίνω τις προκλήσεις της φοιτητικής ζωής. Είμαι εδώ για να ακούσω και να προσφέρω υποστήριξη.",
            
            offer_title: "Πώς μπορώ να βοηθήσω:",
            list_1: "Ακαδημαϊκή Συμβουλευτική", 
            list_2: "Συναισθηματική Υποστήριξη", 
            list_3: "Πόροι & Ευκαιρίες", 
            list_4: "Εξατομικευμένος Σχεδιασμός", 
            list_5: "Επαγγελματικός Προσανατολισμός",

            prep_title: "Προετοιμασία", prep_sub: "Δεξιότητες.",
            star_t: "STAR", star_d: "Συμπεριφορά.",
            psych_t: "Αξιολόγηση Ικανοτήτων", psych_d: "Λογική.",
            case_t: "Μελέτες", case_d: "Σενάρια.",

            elig_title: "Επιλεξιμότητα", elig_desc: "Έλεγχος.", btn_check_elig: "Έλεγχος",
            lbl_q1: "1. Πόλη", lbl_q2: "2. Καθεστώς", lbl_q3: "3. Αγγλικά", link_duolingo_check: "Τεστ",
            lbl_q4: "4. Δίπλωμα", lbl_q5: "5. Τύπος", lbl_q6: "6. Πεδίο", lbl_q7: "7. Πρόγραμμα", lbl_q8: "8. Λονδίνο;", btn_submit_elig: "Υποβολή",

            test_title: "Αγγλικά", test_desc: "Κάντε το τεστ.", btn_test: "Τεστ",
            contact_title: "Ξεκινήστε", contact_sub: "Συμπληρώστε τη φόρμα.",
            form_header: "Ξεκινήστε", 
            lbl_name: "Όνομα", lbl_phone: "Τηλ", lbl_email: "Email", lbl_msg: "Μήνυμα", btn_send: "Αποστολή"
        },

        bg: {
            nav_courses: "Курсове", nav_eligibility: "Допустимост", nav_contact: "Контакт", 
            nav_tagline: "Ние ви помагаме да намерите правилната посока",
            role_title: "Академични Насоки",
            hero_slogan: "\"Насочване през лабиринта с яснота и увереност.\"",
            btn_contact: "Контакт", btn_back: "Назад",

            search_title: "Търсене", btn_find: "Търси",
            lbl_postcode: "Град", lbl_level: "Ниво", lbl_subject: "Предмет", lbl_travel: "Път",

            about_title: "Посветена на Вашия Успех", about_sub: "Студентски Съветник",
            bio_p1: "Аз съм Алина-Сорина Никулеску, вашият отдаден студентски съветник. Ангажирана съм да предлагам подкрепа и насоки на студентите по време на тяхното академично пътуване. Основната ми цел е да помогна на всеки студент да достигне максималния си потенциал.",
            bio_quote: "\"Моята цел е да бъда надежден партньор в академичното пътуване на всеки студент.\"",
            bio_p2: "Разбирам предизвикателствата на студентския живот. Тук съм, за да изслушам и предложа подкрепа.",
            
            offer_title: "Как мога да помогна:",
            list_1: "Академично Консултиране", 
            list_2: "Емоционална Подкрепа", 
            list_3: "Ресурси и Възможности", 
            list_4: "Персонализирано Планиране", 
            list_5: "Кариерно Ориентиране",

            prep_title: "Подготовка", prep_sub: "Умения.",
            star_t: "STAR", star_d: "Поведение.",
            psych_t: "Оценка на Способности", psych_d: "Логика.",
            case_t: "Казуси", case_d: "Сценарии.",

            elig_title: "Допустимост", elig_desc: "Проверка.", btn_check_elig: "Проверка",
            lbl_q1: "1. Град", lbl_q2: "2. Статус", lbl_q3: "3. Английски", link_duolingo_check: "Тест",
            lbl_q4: "4. Диплома", lbl_q5: "5. Тип", lbl_q6: "6. Сфера", lbl_q7: "7. График", lbl_q8: "8. Лондон?", btn_submit_elig: "Изпрати",

            test_title: "Английски", test_desc: "Направете теста.", btn_test: "Тест",
            contact_title: "Започнете", contact_sub: "Попълнете формата.",
            form_header: "Започнете", 
            lbl_name: "Име", lbl_phone: "Тел", lbl_email: "Имейл", lbl_msg: "Съобщение", btn_send: "Изпрати"
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
