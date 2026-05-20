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

$web3FormsKey = "{your api here}"}; 
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alexandra Orban | Student Advisor</title>
    
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
        .icon-fb { color: #1877F2; } .icon-fb:hover { background: #1877F2; color: white; }
        .icon-wa { color: #25D366; } .icon-wa:hover { background: #25D366; color: white; }
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
                    <img src="<?php echo get_template_directory_uri(); ?>/images/AlexandraOrban.jpg" alt="Alexandra Orban" class="relative w-64 h-64 rounded-full border-4 border-white shadow-2xl object-cover">
                </div>
                <div class="text-center md:text-left">
                    <h1 class="text-5xl font-bold text-slate-900 mb-2 serif-font">Alexandra Orban</h1>
                    <p class="font-bold tracking-widest uppercase mb-6" style="color: #ff7f7f;" data-key="role_title">Dedicated Student Advisor</p>
                    
                    <div class="flex flex-wrap gap-4 justify-center md:justify-start mb-6 text-gray-600 font-medium">
                        <div class="flex items-center gap-2"><i data-feather="phone" class="w-4 h-4 text-[#1e3a8a]"></i> 0747 052 1889</div>
                        <div class="flex items-center gap-2"><i data-feather="mail" class="w-4 h-4 text-[#1e3a8a]"></i> Alexandra.orban@ask33.co.uk</div>
                    </div>

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
                    <h2 class="text-3xl font-bold text-slate-900 serif-font" data-key="bio_header">My Approach</h2>
                    <p class="text-slate-500 mt-2" data-key="hobby_header">Beyond Advising</p>
                </div>
                <div class="grid lg:grid-cols-2 gap-12">
                    <div class="space-y-6 text-gray-700 text-lg leading-relaxed">
                        <p data-key="bio_p1">As a dedicated Student Advisor, I’m passionate about helping people make their dreams come true. My support is 100% free, and I guide you through everything — choosing the right course, preparing for interviews, and securing Student Finance.</p>
                        
                        <div class="bg-[#eff6ff] p-6 rounded-xl border-l-4 border-[#1e3a8a] italic text-slate-800">
                            <p data-key="bio_quote">"What sets me apart is my warm approach, genuine commitment, and high success rate. I’m here to answer your questions, ease your worries, and support you at every step."</p>
                        </div>
                        
                        <p data-key="bio_p2">I’m friendly, patient, and truly care about every student I work with. I celebrate your progress, keep you motivated, and make the whole process simple and stress-free.</p>
                        
                        <p class="text-sm text-slate-500 mt-4 border-t border-gray-200 pt-4" data-key="bio_hobby">
                            Outside of my work, I love art, travelling, meeting new people, and learning languages, which helps me connect with students from all backgrounds.
                        </p>
                    </div>
                    
                    <div class="bg-gray-50 p-8 rounded-2xl border border-gray-200 h-fit shadow-sm">
                        <h4 class="font-bold text-xl text-[#1e3a8a] mb-6" data-key="offer_title">What I Offer:</h4>
                        <ul class="space-y-4 text-gray-700">
                            <li class="flex items-start gap-3"><i data-feather="check-circle" class="text-[#2563eb] mt-1 shrink-0"></i> <span data-key="list_1">Friendly and dedicated guidance</span></li>
                            <li class="flex items-start gap-3"><i data-feather="check-circle" class="text-[#2563eb] mt-1 shrink-0"></i> <span data-key="list_2">Making complex decisions simple</span></li>
                            <li class="flex items-start gap-3"><i data-feather="check-circle" class="text-[#2563eb] mt-1 shrink-0"></i> <span data-key="list_3">Proactive support with Student Finance</span></li>
                            <li class="flex items-start gap-3"><i data-feather="check-circle" class="text-[#2563eb] mt-1 shrink-0"></i> <span data-key="list_4">Celebrating your academic milestones</span></li>
                            <li class="flex items-start gap-3"><i data-feather="check-circle" class="text-[#2563eb] mt-1 shrink-0"></i> <span data-key="list_5">100% Free, stress-free assistance</span></li>
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
                <h2 class="text-2xl font-bold text-center text-slate-900 mb-4" data-key="form_header">Contact Me</h2>
                <p class="text-center text-gray-500 mb-8" data-key="form_sub">Ready to turn your dream into reality? Fill in the details below.</p>
                
                <form action="https://api.web3forms.com/submit" method="POST">
                    <input type="hidden" name="access_key" value="<?php echo $web3FormsKey; ?>">
                    <input type="checkbox" name="botcheck" class="hidden" style="display: none;">
                    <input type="hidden" name="subject" value="New Contact for Alexandra Orban">
                    <input type="hidden" name="from_name" value="One Guide Profile">

                    <div class="space-y-5">
                        <input type="text" name="name" class="input-standard" data-key="lbl_name" placeholder="Full Name" required>
                        <input type="tel" name="phone" class="input-standard" data-key="lbl_phone" placeholder="Phone Number" required>
                        <input type="email" name="email" class="input-standard" data-key="lbl_email" placeholder="Email Address" required>
                        <textarea name="message" rows="4" class="input-standard" data-key="lbl_msg" placeholder="How can I help?" required></textarea>
                        <button type="submit" class="w-full btn-blue" data-key="btn_send">Send Message</button>
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
                <input type="hidden" name="subject" value="New Eligibility Check - Alexandra Orban">
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

    const Translations = {
        en: {
            nav_courses: "Courses", nav_eligibility: "Eligibility", nav_contact: "Contact", 
            nav_tagline: "We help you find the right direction",
            role_title: "Dedicated Student Advisor",
            btn_contact: "Get in Touch", btn_back: "Back to Team",
            search_title: "Search Accredited Courses", 
            lbl_postcode: "Postcode / City", lbl_level: "Level", lbl_subject: "Subject", lbl_travel: "Travel", btn_find: "Find",
            
            // Bio
            bio_header: "My Approach", hobby_header: "Beyond Advising",
            bio_p1: "As a dedicated Student Advisor, I’m passionate about helping people make their dreams come true. My support is 100% free, and I guide you through everything — choosing the right course, preparing for interviews, and securing Student Finance.",
            bio_p2: "I’m friendly, patient, and truly care about every student I work with. I celebrate your progress, keep you motivated, and make the whole process simple and stress-free.",
            bio_quote: "\"What sets me apart is my warm approach, genuine commitment, and high success rate. I’m here to answer your questions, ease your worries, and support you at every step.\"",
            bio_hobby: "Outside of my work, I love art, travelling, meeting new people, and learning languages, which helps me connect with students from all backgrounds.",
            
            // Offer
            offer_title: "What I Offer:",
            list_1: "Friendly and dedicated guidance", 
            list_2: "Making complex decisions simple", 
            list_3: "Proactive support with Student Finance", 
            list_4: "Celebrating your academic milestones", 
            list_5: "100% Free, stress-free assistance",
            
            // Prep
            prep_title: "Interview Preparation", prep_sub: "Master your interview skills.",
            star_t: "STAR Method", star_d: "Behavioral answers.", psych_t: "Ability Assessment", psych_d: "Logic & reasoning.", case_t: "Case Studies", case_d: "Real scenarios.",
            
            // Eligibility
            elig_title: "Check Your Eligibility", elig_desc: "Answer a few questions to see if you qualify for Student Finance and admission.", btn_check_elig: "Answer Questions",
            lbl_q1: "1. In which city do you live?", lbl_q2: "2. What is your residency status?", lbl_q3: "3. What is your level of English?", link_duolingo_check: "Not sure? Take test",
            lbl_q4: "4. Do you have a diploma (Bac, Lvl 3, A-Levels)?", lbl_q5: "5. What type of course do you want?", lbl_q6: "6. What field do you want to study?",
            lbl_q7: "7. What is your preferred schedule?", lbl_q8: "8. Would you be willing to study in London?", btn_submit_elig: "Submit Answers",
            
            // Test & Contact
            test_title: "Validate Your English Proficiency", test_desc: "A certified English level is often required for university admission.", btn_test: "Take Duolingo English Test",
            
            form_header: "Need guidance or support?", 
            form_sub: "Fill in the form below and I’ll get back to you to discuss how I can support you. All enquiries are confidential.",
            lbl_name: "Full Name", lbl_email: "Email Address", lbl_phone: "Phone Number", 
            lbl_msg: "How can I help you?", btn_send: "Send Message"
        },

        ro: {
            nav_courses: "Cursuri", nav_eligibility: "Eligibilitate", nav_contact: "Contact", 
            nav_tagline: "Te ajutăm să găsești direcția potrivită",
            role_title: "CONSILIER STUDENT DEDICAT", btn_contact: "Contactează", btn_back: "Înapoi la Echipă",
            search_title: "Caută Cursuri Acreditate", lbl_postcode: "Cod Poștal / Oraș", lbl_level: "Nivel", lbl_subject: "Subiect", lbl_travel: "Transport", btn_find: "Caută",
            
            bio_header: "Abordarea Mea", hobby_header: "Dedicat Succesului Tău",
            bio_p1: "Ca și consilier student dedicat, sunt pasionată să ajut oamenii să-și îndeplinească visele. Sprijinul meu este 100% gratuit.",
            bio_p2: "Sunt prietenoasă, răbdătoare și îmi pasă cu adevărat de fiecare student. Sărbătoresc progresul vostru.",
            bio_quote: "\"Ceea ce mă diferențiază este abordarea mea caldă, angajamentul autentic și rata mare de succes.\"",
            
            offer_title: "Ce Ofer:",
            list_1: "Ghidare prietenoasă", list_2: "Decizii simple", list_3: "Suport proactiv", list_4: "Sărbătorirea succesului", list_5: "100% Gratuit",

            prep_title: "Pregătire Interviu", prep_sub: "Stăpânește abilitățile.", star_t: "Metoda STAR", star_d: "Răspunsuri comportamentale.", psych_t: "Evaluare Abilități", psych_d: "Teste logice.", case_t: "Studii de Caz", case_d: "Scenarii reale.",
            elig_title: "Verifică Eligibilitatea", elig_desc: "Răspunde la întrebări.", btn_check_elig: "Răspunde",
            lbl_q1: "1. În ce oraș locuiești?", lbl_q2: "2. Ce status de rezidență ai?", lbl_q3: "3. Nivel Engleză?", link_duolingo_check: "Nu ești sigur?",
            lbl_q4: "4. Diplomă?", lbl_q5: "5. Tip Curs?", lbl_q6: "6. Domeniu?", lbl_q7: "7. Program?", lbl_q8: "8. Londra?", btn_submit_elig: "Trimite",
            
            test_title: "Validează Competențele", test_desc: "Nivel certificat necesar.", btn_test: "Test Duolingo",
            form_header: "Ai nevoie de îndrumare?", form_sub: "Completează formularul.",
            lbl_name: "Nume Complet", lbl_email: "Email", lbl_phone: "Telefon", lbl_msg: "Cum te pot ajuta?", btn_send: "Trimite"
        }
    };

    function changeLanguage(lang) {
        const t = Translations[lang] || Translations['en'];
        
        document.querySelectorAll('[data-key]').forEach(el => {
            const k = el.getAttribute('data-key');
            if(t[k]) {
                if(el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
                    el.placeholder = t[k];
                } else {
                    el.innerText = t[k];
                }
            }
        });
    }

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

        // Simulate search delay
        setTimeout(() => {
            allSortedResults = coursesDB.filter(course => {
                // A. City/Location Match
                const courseCity = (course.city || "").toLowerCase();
                const courseAddress = (course.address || "").toLowerCase();
                const isLocationMatch = courseCity.includes(postcode) || courseAddress.includes(postcode);

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
                div.innerHTML = '<div class="p-6 bg-white border border-gray-200 rounded-xl text-center text-gray-500">No courses found matching your criteria.</div>';
            }
        }, 500);
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
</script>
</body>
</html>
