<?php

if (!function_exists('get_template_directory_uri')) {
    function get_template_directory_uri() { return '.'; }
}

$baseDir = __DIR__;

$googleMapsKey = "";
$configFile = $baseDir . '/config.json';

if (file_exists($configFile)) {
    $configData = json_decode(file_get_contents($configFile), true);
    $googleMapsKey = $configData['googleMapsKey'] ?? "";
}

// Fallback
if (empty($googleMapsKey)) $googleMapsKey = "PASTE_YOUR_MAPS_KEY_HERE";

$web3FormsKey ="{your api here}"; 

// --- C. LOAD COURSES ---
$coursesFile = $baseDir . '/courses.json';
$coursesJson = file_exists($coursesFile) ? file_get_contents($coursesFile) : "[]";

// --- D. HANDLE REVIEWS ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'submit_review') {
    header('Content-Type: application/json');
    $name = strip_tags(trim($_POST['name'] ?? ''));
    $rating = intval($_POST['rating'] ?? 0);
    $text = strip_tags(trim($_POST['text'] ?? ''));
    
    if ($name && $rating && $text) {
        $file = $baseDir . '/reviews.json';
        $reviews = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
        if (!is_array($reviews)) $reviews = [];
        array_unshift($reviews, ['name' => $name, 'rating' => $rating, 'text' => $text, 'date' => date('Y-m-d')]);
        file_put_contents($file, json_encode($reviews, JSON_PRETTY_PRINT));
        echo json_encode(['status' => 'success', 'reviews' => array_slice($reviews, 0, 10)]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
    }
    exit;
}

// Load Reviews for display
$reviewsData = file_exists($baseDir . '/reviews.json') ? json_decode(file_get_contents($baseDir . '/reviews.json'), true) : [];
$recentReviewsJson = json_encode(is_array($reviewsData) ? $reviewsData : []);

// --- E. TEAM DATA (Updated for 11 Members) ---
$team = [
    ['name' => 'Alexandra Orban', 'img' => 'AlexandraOrban.jpg', 'role_key' => 'role_finance', 'desc_key' => 'desc_alexandra', 'slug' => 'alexandra-orban'],
    ['name' => 'Carmen Mihaila', 'img' => 'CarmenMihaila.jpg', 'role_key' => 'role_social', 'desc_key' => 'desc_carmen', 'slug' => 'carmen-mihaila'],
    ['name' => 'Ovidiu Suteu', 'img' => 'OvidiuHoriaSuteu.jpg', 'role_key' => 'role_eligibility', 'desc_key' => 'desc_ovidiu', 'slug' => 'ovidiu-horia-suteu'],
    ['name' => 'Georgiana Moraru', 'img' => 'GeorgianaMoraru.jpg', 'role_key' => 'role_app', 'desc_key' => 'desc_georgiana', 'slug' => 'georgiana-moraru'],
    ['name' => 'Valentina Constantin', 'img' => 'ValentinaConstantin.jpg', 'role_key' => 'role_advisor', 'desc_key' => 'desc_valentina', 'slug' => 'valentina-constantin'],
    ['name' => 'Madalina Rusu', 'img' => 'MadalinaRusu.jpg', 'role_key' => 'role_enroll', 'desc_key' => 'desc_madalina', 'slug' => 'madalina-rusu'],
    ['name' => 'Ovidiu Timis', 'img' => 'OvidiuAdrianTimis.jpg', 'role_key' => 'role_multi', 'desc_key' => 'desc_timis', 'slug' => 'ovidiu-adrian-timis'],
    ['name' => 'Laurentiu Niculescu', 'img' => 'LaurentiuNiculescu.jpg', 'role_key' => 'role_statement', 'desc_key' => 'desc_laurentiu', 'slug' => 'laurentiu-niculescu'],
    ['name' => 'Alina Niculescu', 'img' => 'AlinaSorinaNiculescu.jpg', 'role_key' => 'role_guide', 'desc_key' => 'desc_alina', 'slug' => 'alina-sorina-niculescu'],
    
    ['name' => 'Andreea Macxim', 'img' => 'AndreeaMacxim.jpg', 'role_key' => 'role_advisor', 'desc_key' => 'desc_andreea', 'slug' => 'andreea-maxim'],
    
    ['name' => 'Join Us', 'img' => 'StudentAdvisor.jpg', 'role_key' => 'role_recruit', 'desc_key' => 'desc_join', 'slug' => 'join-team']
];
?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>One Guide | Higher Education Consultants</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <?php if (!empty($googleMapsKey)): ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo htmlspecialchars($googleMapsKey); ?>&libraries=geometry" async defer></script>
    <?php endif; ?>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <meta name="description" content="Expert UK university admission consultants. We help students secure Student Finance England (SFE) loans up to £15,000/year. Apply for Foundation, Bachelor, and Master degrees today.">
    <meta name="keywords" content="Student Finance England, UK University Admissions, SFE Loans, Tuition Fee Loan, Maintenance Loan, UK Higher Education, Study in UK, University Consultant London">
    <meta name="author" content="One Guide Advisors">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://www.one-guide.co.uk/" />

    <style>
        :root { color-scheme: light; }
        
        #bg-fixed {
            position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; z-index: -50;
            background: url('https://images.pexels.com/photos/267885/pexels-photo-267885.jpeg?auto=compress&cs=tinysrgb&w=1920');
            background-size: cover; 
            background-position: center;
            background-attachment: fixed;
        }
        
        body { 
            background-color: transparent; 
            font-family: 'Lato', sans-serif; 
            color: #1f2937; 
            overflow-x: hidden; 
        }
        
        h1, h2, h3, .serif-font { font-family: 'Playfair Display', serif; }
        
        .glass-effect { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.3); }
        .fade-in { animation: fadeIn 0.8s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        .content-card { 
            background: #ffffff; 
            border-radius: 1.5rem; 
            padding: 2.5rem; 
            color: #1f2937;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(229, 231, 235, 0.5);
        }

        .prep-card { background: #ffffff; border: 1px solid #e2e8f0; color: var(--primary); padding: 2rem; border-radius: 1rem; transition: transform 0.2s; display: block; text-align: center; height: 100%; }
        .prep-card:hover { transform: translateY(-5px); border-color: var(--primary); box-shadow: 0 10px 20px rgba(30, 58, 138, 0.1); }
        .input-standard { 
            background: #f9fafb; border: 1px solid #d1d5db; color: #1f2937; 
            border-radius: 0.5rem; padding: 0.75rem; transition: all 0.2s;
        }
        .input-standard:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); outline: none; background: #ffffff; }
        
        .btn-primary {
            background-color: #3b82f6; color: white; padding: 10px 28px;
            border-radius: 8px; font-weight: 700; transition: transform 0.2s, background-color 0.2s; display: inline-flex; align-items: center; justify-content: center; text-align: center;
        }
        .btn-primary:hover { background-color: #2563eb; transform: translateY(-2px); }

        .pagination-btn { padding: 8px 16px; background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 6px; font-weight: 600; color: #334155; transition: all 0.2s; }
        .pagination-btn:hover:not(:disabled) { background: #e2e8f0; color: #0f172a; }
        .pagination-btn:disabled { opacity: 0.5; cursor: not-allowed; }

        .footer-socials { gap: 1rem; } 
        .footer-socials a { 
            display: inline-flex; align-items: center; justify-content: center; 
            width: 50px; height: 50px; border-radius: 50%; background: #f8fafc;
            transition: all 0.3s ease; font-size: 1.6rem; box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .footer-socials a:hover { transform: translateY(-4px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .icon-fb { color: #1877F2; } .icon-fb:hover { background: #1877F2; color: white; }
        .icon-wa { color: #25D366; } .icon-wa:hover { background: #25D366; color: white; }
        .icon-mail { color: #475569; } .icon-mail:hover { background: #475569; color: white; }

        .chat-btn { 
            position: fixed; bottom: 30px; right: 30px; z-index: 100; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.2); width: 64px; height: 64px; 
            border-radius: 50%; display: flex; align-items: center; justify-content: center; 
            background: #3b82f6; color: white; transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            border: 2px solid white; cursor: pointer;
        }
        .chat-btn:hover { transform: scale(1.1); box-shadow: 0 15px 40px rgba(37, 99, 235, 0.4); }
        .chat-window { 
            position: fixed; bottom: 110px; right: 30px; width: 350px; max-width: 90vw; height: 500px; 
            background: #ffffff; border-radius: 20px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.2); 
            z-index: 99; display: none; flex-direction: column; overflow: hidden; border: 1px solid #e5e7eb;
            animation: chatPopup 0.4s ease-out;
        }
        @keyframes chatPopup { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .chat-header { background: #3b82f6; color: white; padding: 15px; font-weight: bold; display: flex; justify-content: space-between; align-items: center; }
        .chat-messages { flex: 1; padding: 15px; overflow-y: auto; background: #f9fafb; display: flex; flex-direction: column; gap: 10px; }
        .msg { padding: 10px 14px; border-radius: 14px; max-width: 85%; line-height: 1.4; font-size: 0.9rem; }
        .msg.bot { background: #eef2ff; color: #1e3a8a; align-self: flex-start; border-bottom-left-radius: 2px; }
        .msg.user { background: #3b82f6; color: white; align-self: flex-end; border-bottom-right-radius: 2px; }
        .chat-input-area { padding: 10px; background: white; border-top: 1px solid #f3f4f6; display: flex; gap: 8px; align-items: center; }
        .chat-input-field { flex: 1; padding: 10px 14px; border-radius: 50px; border: 1px solid #e5e7eb; background: #f9fafb; outline: none; font-size: 0.9rem; }
        .chat-action-btn { display: inline-block; background: #ffffff; color: #3b82f6; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: bold; margin-top: 5px; text-decoration: none; border: 1px solid #bfdbfe; transition: all 0.2s; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .chat-action-btn:hover { background: #3b82f6; color: white; }
        
        .desktop-carousel { display: none; }
        @media (min-width: 1024px) {
            .desktop-carousel { display: flex; perspective: 2000px; padding: 40px 0 60px; justify-content: center; min-height: 600px; overflow: visible; }
            .carousel-spinner { width: 320px; height: 580px; position: relative; transform-style: preserve-3d; transition: transform 1s; margin: 0 auto; }
            .team-card-3d { 
                position: absolute; width: 320px; height: 580px; left: 0; top: 0;
                background: #ffffff; border-radius: 1rem; overflow: hidden; 
                box-shadow: 0 20px 40px rgba(0,0,0,0.1); border: 1px solid #e5e7eb; 
                backface-visibility: hidden; cursor: pointer; display: flex; flex-direction: column;
            }
            .team-card-3d:nth-child(1) { transform: rotateY(0deg) translateZ(650px); }
            .team-card-3d:nth-child(2) { transform: rotateY(32.7deg) translateZ(650px); }
            .team-card-3d:nth-child(3) { transform: rotateY(65.4deg) translateZ(650px); }
            .team-card-3d:nth-child(4) { transform: rotateY(98.1deg) translateZ(650px); }
            .team-card-3d:nth-child(5) { transform: rotateY(130.9deg) translateZ(650px); }
            .team-card-3d:nth-child(6) { transform: rotateY(163.6deg) translateZ(650px); }
            .team-card-3d:nth-child(7) { transform: rotateY(196.3deg) translateZ(650px); }
            .team-card-3d:nth-child(8) { transform: rotateY(229deg) translateZ(650px); }
            .team-card-3d:nth-child(9) { transform: rotateY(261.8deg) translateZ(650px); }
            .team-card-3d:nth-child(10) { transform: rotateY(294.5deg) translateZ(650px); }
            .team-card-3d:nth-child(11) { transform: rotateY(327.2deg) translateZ(650px); }
        }

        .mobile-slider { display: none; }
        @media (max-width: 1023px) {
            .mobile-slider { display: flex; width: 100%; overflow-x: auto; scroll-snap-type: x mandatory; padding: 20px; gap: 20px; z-index: 20; position: relative; }
            .mobile-card { flex: 0 0 85%; max-width: 320px; scroll-snap-align: center; background: #ffffff; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2); border: 1px solid #e5e7eb; overflow: hidden; display: flex; flex-direction: column; align-items: center; text-align: center; padding: 1.5rem; }
        }


.tv-neon-wrapper {
    position: relative;
    z-index: 10;
}


.tv-neon-glow {
    position: absolute;
    inset: -2px; /* Slightly larger than the TV to show the glow */
    border-radius: 1.5rem;
    z-index: -1;
    animation: neonCycle 8s infinite alternate linear;
}


@keyframes neonCycle {
    0% {
        box-shadow: -25px 0px 60px -10px #0ff, 25px 0px 60px -10px #f0f;
    }
    33% {
        box-shadow: -25px 0px 60px -10px #7c3aed, 25px 0px 60px -10px #2563eb;
    }
    66% {
        box-shadow: -25px 0px 60px -10px #10b981, 25px 0px 60px -10px #3b82f6;
    }
    100% {
        box-shadow: -25px 0px 60px -10px #f43f5e, 25px 0px 60px -10px #8b5cf6;
    }
}


.tv-screen-glass {
    position: absolute;
    top: 0; left: 0; right: 0; height: 100%;
    background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 40%);
    pointer-events: none; /* Allows clicking the video */
    z-index: 20;
}

.inner-card-blue {
    background: #1e3a8a; /* Deep Blue */
    border: 1px solid #1e40af;
    color: white;
    padding: 2.5rem;
    border-radius: 1.5rem;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 10px 25px rgba(30, 58, 138, 0.3);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
}
.inner-card-blue:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(30, 58, 138, 0.5);
    background: #1e40af; /* Slightly lighter on hover */
}
.inner-card-blue i {
    transition: transform 0.3s;
}
.inner-card-blue:hover i {
    transform: scale(1.1);
}

        .star-rating { display: flex; gap: 5px; cursor: pointer; }
        .star-icon { color: #d1d5db; transition: color 0.2s; }
        .star-icon.active { color: #facc15; fill: #facc15; }
        .star-icon.hovered { color: #fde047; fill: #fde047; }
    </style>
</head>
<body class="bg-gray-50">

    <div id="bg-fixed"></div>

    <nav class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-28 flex justify-between items-center relative">
            
            <a href="index.php" class="flex flex-col items-center justify-center gap-0 group no-underline">
                <img src="<?php echo get_template_directory_uri(); ?>/images/One-Guide.png" alt="Logo" class="h-10 w-auto object-contain mb-1 transition group-hover:scale-105">
                <span class="font-bold text-sm text-blue-900 leading-tight serif-font">One Guide</span>
                <span class="text-sm font-medium text-gray-700 hidden sm:block">We help you find the right direction</span>
                <span class="text-[9px] font-bold text-blue-900 tracking-wide uppercase mt-0.5">
                    Powered by <span class="hover:text-red-600 active:text-red-700 transition-colors cursor-pointer" onclick="window.open('https://www.ask33.co.uk/', '_blank')">ASK 33</span>
                </span>
            </a>

            <div class="hidden md:flex gap-8 items-center font-medium text-gray-600">
                <a href="#course-search" class="hover:text-blue-600 transition" data-key="nav_courses">Courses</a>
                <a href="#team" class="hover:text-blue-600 transition" data-key="nav_team">Advisors</a>
                <a href="#reviews" class="hover:text-blue-600 transition" data-key="nav_reviews">Reviews</a>
                
                <div class="relative inline-block">
                    <select onchange="setLang(this.value)" class="input-standard py-2 pl-3 pr-8 text-sm bg-white border-gray-200 cursor-pointer">
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
                
                <a href="#contact" class="btn-primary shadow-md" data-key="nav_contact">Contact</a>
            </div>

            <button class="md:hidden p-2 text-slate-600 border border-slate-300 rounded-lg hover:bg-slate-100 transition" onclick="document.getElementById('mobile-menu').classList.toggle('hidden');">
                <i data-feather="menu"></i>
            </button>

            <div id="mobile-menu" class="hidden absolute top-28 left-0 w-full bg-white border-b border-gray-200 shadow-xl flex-col p-6 gap-4 text-center">
                <a href="#course-search" class="block py-2 font-medium text-gray-600 hover:text-blue-600" onclick="this.parentNode.classList.add('hidden')" data-key="nav_courses">Courses</a>
                <a href="#team" class="block py-2 font-medium text-gray-600 hover:text-blue-600" onclick="this.parentNode.classList.add('hidden')" data-key="nav_team">Advisors</a>
                <a href="#reviews" class="block py-2 font-medium text-gray-600 hover:text-blue-600" onclick="this.parentNode.classList.add('hidden')" data-key="nav_reviews">Reviews</a>
                <div class="border-t border-gray-100 pt-4 mt-2">
                    <select onchange="setLang(this.value); this.parentNode.parentNode.classList.add('hidden');" class="w-full p-3 border border-gray-300 rounded bg-white text-gray-700">
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
                <a href="#contact" class="btn-primary w-full mt-4 block text-center" onclick="this.parentNode.classList.add('hidden')" data-key="nav_contact">Contact</a>
            </div>
        </div>
    </nav>

    <section class="relative pt-24 pb-8 px-6 text-center">
        <div class="max-w-3xl mx-auto content-card fade-in bg-white/90 backdrop-blur-sm border border-white/50">
            <h1 class="text-5xl md:text-6xl font-bold mb-4 serif-font leading-tight">
                <span data-key="hero_h1_1">Higher Education &</span> <br><span class="text-blue-600" data-key="hero_h1_2">Professional Pathways</span>
            </h1>
            <p class="text-lg font-medium mb-4 max-w-xl mx-auto" data-key="hero_sub">Expert guidance on university admissions.</p>
        </div>
    </section>
    
    <section class="py-16 px-6 relative z-10">
    <div class="max-w-5xl mx-auto tv-neon-wrapper mt-10">
        
        <div class="relative bg-gray-900 rounded-2xl border-[6px] border-gray-950 p-2 shadow-2xl flex flex-col items-center">
            
            <div class="tv-neon-glow"></div>
            
            <div class="w-full aspect-video bg-black rounded-xl overflow-hidden relative">
                
                <div class="tv-screen-glass"></div>
                
                <video class="w-full h-full object-cover" controls autoplay muted loop playsinline>
                    <source src="<?php echo get_template_directory_uri(); ?>/video/video.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                
            </div>
            
            <div class="w-full h-6 mt-1 rounded-b-xl flex justify-center items-center relative">
                <div class="w-1.5 h-1.5 rounded-full bg-red-600 shadow-[0_0_8px_2px_rgba(220,38,38,0.8)]"></div>
            </div>
        </div>

        <div class="flex flex-col items-center relative z-0 -mt-2">
            <div class="w-20 h-10 bg-gradient-to-b from-gray-900 to-gray-800"></div>
            <div class="w-72 h-4 bg-gradient-to-b from-gray-700 to-gray-900 rounded-t-[50%] shadow-[0_10px_20px_rgba(0,0,0,0.5)] border-b-4 border-gray-950"></div>
        </div>

    </div>
</section>
    <section id="course-search" class="px-6 relative z-10 -mt-4">
        <div class="max-w-5xl mx-auto content-card fade-in text-center p-8">
            <h2 class="text-xl font-bold serif-font mb-6" data-key="search_title">Search Accredited Courses</h2>
            
            <form onsubmit="handleSearch(event)" class="grid md:grid-cols-5 gap-6 text-left">
                
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
                        <button class="w-full btn-primary py-3" data-key="btn_find">Find</button>
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
    <section id="leadership" class="py-16 px-6 mt-8">
        <div class="max-w-4xl mx-auto text-center mb-10">
            <h2 class="text-4xl font-bold text-white drop-shadow-lg serif-font mb-4" data-key="leader_title">Our Leadership</h2>
            <div class="w-24 h-1 bg-blue-500 mx-auto rounded-full shadow-lg"></div>
        </div>
        
        <a href="<?php echo home_url('/casandra-banu/'); ?>" class="block max-w-4xl mx-auto group transform transition duration-500 hover:-translate-y-2">
            
            <div class="bg-white/95 backdrop-blur-md rounded-[2rem] p-8 md:p-12 shadow-xl hover:shadow-2xl border-2 border-white/60 flex flex-col md:flex-row items-center gap-10 transition-all duration-500 relative overflow-hidden">
                
                <div class="absolute -top-20 -right-20 w-64 h-64 bg-blue-100 rounded-full blur-3xl opacity-50 group-hover:opacity-80 transition duration-500"></div>

                <div class="relative shrink-0 z-10">
                    <div class="absolute inset-0 bg-blue-600 blur-2xl opacity-20 rounded-full group-hover:opacity-40 transition duration-500"></div>
                    <img src="<?php echo get_template_directory_uri(); ?>/images/CasandraBanu.jpg" 
                         alt="Casandra Banu" 
                         class="relative w-56 h-56 md:w-72 md:h-72 rounded-full object-cover border-8 border-white shadow-xl group-hover:scale-105 transition duration-500" 
                         onerror="this.src='https://via.placeholder.com/300'">
                </div>
                
                <div class="text-center md:text-left flex-1 z-10">
                    <h3 class="text-4xl md:text-5xl font-bold mb-2 text-slate-900 serif-font group-hover:text-blue-700 transition-colors">Casandra Banu</h3>
                    <span class="text-blue-600 font-bold tracking-widest text-sm md:text-base uppercase block mb-6" data-key="leader_role">Team Leader & Educational Consultant</span>
                    
                    <p class="mb-8 text-lg md:text-xl leading-relaxed text-slate-600" data-key="leader_desc">
                     UK admissions and student finance expert, guiding students with clarity, empathy, and real-life experience. Through one clear, structured approach, I support informed decisions and lead student advisors to deliver the same trusted guidance.
                    </p>
                    
                    <span class="inline-flex items-center gap-2 px-8 py-4 bg-blue-50 text-blue-700 border border-blue-200 rounded-xl font-bold text-base md:text-lg group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-600 transition-all shadow-sm" data-key="btn_view">
                        View Profile <i data-feather="arrow-right" class="w-5 h-5"></i>
                    </span>
                </div>
                
            </div>
        </a>
    </section>
    <section id="team" class="py-12 mt-4 rounded-3xl overflow-hidden relative">
        <div class="container mx-auto text-center mb-8">
            <h2 class="text-3xl font-bold serif-font text-white drop-shadow-md" data-key="team_title">Meet the Team</h2>
            <p class="text-white/90 drop-shadow-sm font-medium" data-key="team_sub">Expert advisors dedicated to your journey.</p>
        </div>
        
        <div class="hidden lg:flex justify-center gap-6 mb-8 relative z-20">
            <button onclick="rotateCarousel(-1)" class="w-12 h-12 bg-white border border-gray-200 rounded-full shadow text-gray-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition"><i data-feather="chevron-left"></i></button>
            <button onclick="rotateCarousel(1)" class="w-12 h-12 bg-white border border-gray-200 rounded-full shadow text-gray-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition"><i data-feather="chevron-right"></i></button>
        </div>

        <div class="hidden md:block desktop-carousel"> 
            <div class="carousel-spinner" id="carousel">
                <?php foreach($team as $m): ?>
                    <?php if ($m['slug'] === 'join-team'): ?>
                        <a href="<?php echo home_url('/' . $m['slug'] . '/'); ?>" class="team-card-3d group relative overflow-hidden" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); border: none;">
                            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-20 h-20 bg-white opacity-10 rounded-full blur-xl"></div>
                            <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/joinus.jpg" class="w-48 h-48 rounded-full mx-auto mt-10 border-4 border-white/40 object-cover shadow-lg group-hover:scale-105 transition-transform duration-300">
                            <div class="p-6 text-center relative z-10">
                                <h3 class="text-2xl font-bold text-white mb-1 tracking-wide">Grow With Us</h3>
                                <p class="text-blue-200 text-xs font-bold uppercase mb-4 tracking-wider" data-key="<?php echo $m['role_key']; ?>">Recruitment</p>
                                <p class="team-desc text-white/90 text-sm leading-relaxed mb-4 font-medium" data-key="<?php echo $m['desc_key']; ?>">"Turn your networking skills into a career."</p>
                                <span class="mt-auto inline-block px-6 py-2 bg-white text-blue-900 rounded-full text-sm font-bold shadow-md group-hover:shadow-lg transition-all transform group-hover:-translate-y-1">Apply Now</span>
                            </div>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo home_url('/' . $m['slug'] . '/'); ?>" class="team-card-3d group bg-white">
                            <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/<?php echo $m['img']; ?>" class="w-48 h-48 rounded-full mx-auto mt-10 border-4 border-gray-100 object-cover shadow-md group-hover:shadow-xl transition-all duration-300">
                            <div class="p-6 text-center">
                                <h3 class="text-xl font-bold text-blue-900 mb-1"><?php echo $m['name']; ?></h3>
                                <p class="text-amber-500 text-xs font-bold uppercase mb-3" data-key="<?php echo $m['role_key']; ?>">Student Advisor</p>
                                <p class="team-desc" style="font-size:0.9rem; color:#6b7280; line-height:1.5; margin-bottom:15px; display:-webkit-box; -webkit-line-clamp:4; -webkit-box-orient:vertical; overflow:hidden;" data-key="<?php echo $m['desc_key']; ?>">"Dedicated support for your journey."</p>
                                <span class="mt-auto inline-block text-sm text-blue-600 underline font-bold group-hover:text-blue-800 transition-colors" data-key="btn_view">View Profile</span>
                            </div>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="md:hidden mobile-slider">
            <?php foreach($team as $m): ?>
                <a href="<?php echo home_url('/' . $m['slug'] . '/'); ?>" class="mobile-card group">
                    <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/<?php echo $m['img']; ?>" class="w-32 h-32 rounded-full mx-auto mb-4 border-4 border-gray-50 object-cover shadow-md" onerror="this.src='https://via.placeholder.com/150'">
                    <h3 class="text-lg font-bold text-blue-900 mb-1"><?php echo $m['name']; ?></h3>
                    <p class="text-amber-500 text-xs font-bold uppercase mb-3" data-key="<?php echo $m['role_key']; ?>">Advisor</p>
                    <span class="inline-block text-sm text-blue-600 underline font-bold" data-key="btn_view">View Profile</span>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

 <section id="prep" class="py-24 px-6 bg-transparent">
        <div class="max-w-6xl mx-auto">
            
            <h2 class="text-3xl md:text-4xl font-bold text-center text-white mb-12 serif-font drop-shadow-md" data-key="prep_title">Interview Preparation</h2>
            
            <div class="grid md:grid-cols-3 gap-8 text-center">
                
                <a href="<?php echo home_url('/prep-star/'); ?>" class="group block bg-[#1e3a8a] rounded-2xl p-10 transition-transform duration-300 hover:-translate-y-2 shadow-lg hover:shadow-2xl border border-blue-900/50">
                    <div class="mb-6 transform group-hover:scale-110 transition-transform duration-300">
                        <i data-feather="star" class="w-12 h-12 mx-auto text-yellow-400" style="stroke-width: 2;"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3 serif-font" data-key="star_t">STAR Method</h3>
                    <p class="text-blue-100 font-light" data-key="star_d">Master behavioral questions.</p>
                </a>

                <a href="<?php echo home_url('/prep-psych/'); ?>" class="group block bg-[#1e3a8a] rounded-2xl p-10 transition-transform duration-300 hover:-translate-y-2 shadow-lg hover:shadow-2xl border border-blue-900/50">
                    <div class="mb-6 transform group-hover:scale-110 transition-transform duration-300">
                        <i data-feather="cpu" class="w-12 h-12 mx-auto text-cyan-400" style="stroke-width: 2;"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3 serif-font" data-key="psych_t">Ability Assessment</h3>
                    <p class="text-blue-100 font-light" data-key="psych_d">Logic & reasoning practice.</p>
                </a>

                <a href="<?php echo home_url('/prep-case/'); ?>" class="group block bg-[#1e3a8a] rounded-2xl p-10 transition-transform duration-300 hover:-translate-y-2 shadow-lg hover:shadow-2xl border border-blue-900/50">
                    <div class="mb-6 transform group-hover:scale-110 transition-transform duration-300">
                        <i data-feather="briefcase" class="w-12 h-12 mx-auto text-pink-300" style="stroke-width: 2;"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3 serif-font" data-key="case_t">Case Studies</h3>
                    <p class="text-blue-100 font-light" data-key="case_d">Real-world scenarios.</p>
                </a>

            </div>
        </div>
    </section>

    <section id="reviews" class="py-12 px-6 mt-10 mx-4 content-card max-w-4xl mx-auto bg-white/95 backdrop-blur-sm">
        <h2 class="text-3xl font-bold text-center mb-10 serif-font" data-key="rev_title">Student Reviews</h2>
        <div id="reviews-container" class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12 text-left"></div>
        <div class="max-w-2xl mx-auto text-left border-t border-gray-200 pt-8">
            <h3 class="text-xl font-bold mb-6 text-center text-blue-900" data-key="rev_leave">Leave a Review</h3>
            <form onsubmit="handleReviewSubmit(event)">
                <div class="mb-4">
                    <input type="text" id="review-name" class="input-standard w-full" required data-key="ph_name" placeholder="Your Name">
                </div>
                <div class="flex justify-center gap-2 star-rating mb-6" id="star-rating" onmouseleave="resetStars()">
                    <i data-feather="star" class="star-icon w-8 h-8 cursor-pointer" onmouseover="highlightStars(1)" onclick="setRating(1)"></i>
                    <i data-feather="star" class="star-icon w-8 h-8 cursor-pointer" onmouseover="highlightStars(2)" onclick="setRating(2)"></i>
                    <i data-feather="star" class="star-icon w-8 h-8 cursor-pointer" onmouseover="highlightStars(3)" onclick="setRating(3)"></i>
                    <i data-feather="star" class="star-icon w-8 h-8 cursor-pointer" onmouseover="highlightStars(4)" onclick="setRating(4)"></i>
                    <i data-feather="star" class="star-icon w-8 h-8 cursor-pointer" onmouseover="highlightStars(5)" onclick="setRating(5)"></i>
                </div>
                <div class="mb-6">
                    <textarea id="review-text" rows="3" class="input-standard w-full" required data-key="ph_comment" placeholder="Comment"></textarea>
                </div>
                <div class="text-center">
                    <button class="btn-primary" data-key="btn_post">Post Review</button>
                </div>
            </form>
        </div>
    </section>

    <section id="contact" class="py-12 px-6 content-card mt-10 mx-6 mb-20 max-w-2xl mx-auto bg-white/95 backdrop-blur-sm">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold serif-font mb-4 text-blue-900" data-key="contact_title">Get in Touch</h2>
            <p data-key="contact_sub">Start your academic journey today.</p>
        </div>
        <form action="https://api.web3forms.com/submit" method="POST">
            <input type="hidden" name="access_key" value="<?php echo $web3FormsKey; ?>">
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div><label class="block text-sm font-bold mb-2 text-gray-700" data-key="lbl_name">Full Name</label><input type="text" name="name" class="input-standard w-full" required></div>
                <div><label class="block text-sm font-bold mb-2 text-gray-700" data-key="lbl_phone">Phone</label><input type="tel" name="phone" class="input-standard w-full" required></div>
            </div>
            <div class="mb-6"><label class="block text-sm font-bold mb-2 text-gray-700" data-key="lbl_email">Email</label><input type="email" name="email" class="input-standard w-full" required></div>
            <div class="mb-6"><label class="block text-sm font-bold mb-2 text-gray-700" data-key="lbl_msg">Message</label><textarea name="message" rows="4" class="input-standard w-full" required></textarea></div>
            <div class="text-center"><button type="submit" class="btn-primary w-full py-4 text-lg" data-key="btn_send">Send Message</button></div>
        </form>
    </section>

    <button class="chat-btn" onclick="toggleChat()"><i data-feather="message-circle" class="w-8 h-8 text-white"></i></button>
    <div id="chat-window" class="chat-window">
        <div class="chat-header">
            <div class="flex items-center gap-2"><div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div><span>One Guide Assistant</span></div>
            <button onclick="toggleChat()" class="opacity-80 hover:opacity-100 transition"><i data-feather="x"></i></button>
        </div>
        <div id="chat-messages" class="chat-messages">
            <div class="msg bot">Hello! 👋 I can help you find a course or contact an advisor.</div>
        </div>
        <div class="chat-input-area">
            <input type="text" id="chat-input" class="chat-input-field" placeholder="Ask a question..." onkeypress="if(event.key==='Enter') sendChat()">
            <button onclick="sendChat()" class="p-2 text-blue-600 hover:text-blue-800 transition"><i data-feather="send" class="w-5 h-5"></i></button>
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
    document.addEventListener('DOMContentLoaded', function() {
        feather.replace();
        loadReviews();
    });

    const coursesDB = <?php echo $coursesJson ?: "[]"; ?>;
    const serverReviews = <?php echo $recentReviewsJson ?: "[]"; ?>;
    
    let allSortedResults = [];
    let currentPage = 1;
    const resultsPerPage = 5;

    const translations = {
        en: {
            nav_courses: "Courses", nav_team: "Advisors", nav_reviews: "Reviews", nav_contact: "Contact", nav_prep: "Prep",
            nav_tagline: "We help you find the right direction",
            hero_h1_1: "Higher Education &", hero_h1_2: "Professional Pathways", hero_sub: "Expert guidance on university admissions.",
            search_title: "Search Accredited Courses", lbl_postcode: "City", lbl_level: "Level", lbl_subject: "Subject", lbl_travel: "Travel", btn_find: "Find",
            leader_title: "Our Leadership", leader_role: "Team Leader", leader_desc: "UK admissions and student finance expert, guiding students with clarity, empathy, and real-life experience. Through one clear, structured approach, I support informed decisions and lead student advisors to deliver the same trusted guidance.", btn_view: "View Profile",
            team_title: "Meet the Team", team_sub: "Expert advisors dedicated to your journey.",
            role_finance: "Finance Expert", desc_alexandra: "Specializes in Student Finance England (SFE) appeals.",
            role_social: "Social Work Specialist", desc_carmen: "Expert in Health & Social Care admissions.",
            role_eligibility: "Eligibility Expert", desc_ovidiu: "Ensures residency status meets requirements.",
            role_app: "Application Specialist", desc_georgiana: "Makes the university application process simple.",
            role_advisor: "Student Advisor", desc_valentina: "Dedicated support for mature students.",
            role_enroll: "Enrollment Officer", desc_madalina: "Specialist in enrollment procedures.",
            role_multi: "Multilingual Advisor", desc_timis: "Fluent in 4 languages.",
            role_statement: "Statement Expert", desc_laurentiu: "Expert in writing compelling Personal Statements.",
            role_guide: "Academic Guide", desc_alina: "Provides detailed academic guidance.",
            role_recruit: "Recruitment", desc_join: "Start your career as a Student Advisor today.",
            desc_andreea: "Specializing in supporting students through every stage of their academic journey with calm, patient, and personalised support.",
            prep_title: "Interview Preparation", star_t: "STAR Method", star_d: "Master behavioral questions.", psych_t: "Ability Assessment", psych_d: "Logic & reasoning practice.", case_t: "Case Studies", case_d: "Real-world scenarios.",
            rev_title: "Student Reviews", rev_leave: "Leave a Review", ph_name: "Your Name", ph_comment: "Comment", btn_post: "Post Review",
            contact_title: "Get in Touch", contact_sub: "Start your academic journey today.",
            lbl_name: "Full Name", lbl_phone: "Phone Number", lbl_email: "Email Address", lbl_msg: "How can we help?", btn_send: "Send Message",
            
            chat_title: "One Guide Assistant",
            ph_ask: "Ask a question...",
            btn_send_chat: "Send",
            chat_welcome: "Hello! 👋 I can help you find a course or contact an advisor.",
            chat_finance: "We specialize in **Student Finance England**. You can get up to £15,000/year.",
            chat_courses: "We offer degrees in **Business, Health, Computing, Law & Arts**.",
            chat_contact: "You can reach us via the contact form. We reply within 24 hours.",
            chat_fallback: "I can help with **Courses**, **Finance**, or **Admissions**."
        },
        ro: {
            nav_courses: "Cursuri", nav_team: "Echipă", nav_reviews: "Recenzii", nav_contact: "Contact", nav_prep: "Pregătire", nav_tagline: "Te ajutăm să găsești direcția potrivită",
            hero_h1_1: "Învățământ Superior &", hero_h1_2: "Trasee Profesionale", hero_sub: "Ghidare expertă în admiteri universitare.",
            search_title: "Caută Cursuri Acreditate", lbl_postcode: "Oraș", lbl_level: "Nivel", lbl_subject: "Subiect", lbl_travel: "Transport", btn_find: "Caută",
            leader_title: "Conducerea Noastră", leader_role: "Lider Echipă", leader_desc: "Expert în admiteri și finanțarea studiilor în UK, ghidând studenții cu claritate, empatie și experiență reală.", btn_view: "Vezi Profil",
            team_title: "Cunoaște Echipa", team_sub: "Consilieri experți dedicați călătoriei tale.",
            role_finance: "Expert Finanțe", desc_alexandra: "Specialist în apeluri SFE.",
            role_social: "Asistență Socială", desc_carmen: "Expert în admiteri Sănătate.",
            role_eligibility: "Expert Eligibilitate", desc_ovidiu: "Asigură statutul de rezidență.",
            role_app: "Specialist Aplicații", desc_georgiana: "Simplifică procesul de aplicare.",
            role_advisor: "Consilier Studenți", desc_valentina: "Suport pentru studenți maturi.",
            role_enroll: "Ofițer Înscrieri", desc_madalina: "Specialist în proceduri de înscriere.",
            role_multi: "Consilier Multilingv", desc_timis: "Vorbește fluent 4 limbi.",
            role_statement: "Expert Eseuri", desc_laurentiu: "Expert în scrierea declarațiilor personale.",
            role_guide: "Ghid Academic", desc_alina: "Oferă ghidare academică detaliată.",
            role_recruit: "Recrutare", desc_join: "Începe-ți cariera azi.",
            desc_andreea: "Suport calm, răbdător și personalizat.",
            prep_title: "Pregătire Interviu", star_t: "Metoda STAR", star_d: "Întrebări comportamentale.", psych_t: "Evaluarea Abilităților", psych_d: "Logică și raționament.", case_t: "Studii de Caz", case_d: "Scenarii reale.",
            rev_title: "Recenzii Studenți", rev_leave: "Lasă o Recenzie", ph_name: "Numele Tău", ph_comment: "Comentariu", btn_post: "Postează",
            contact_title: "Contactează-ne", contact_sub: "Începe călătoria academică azi.",
            lbl_name: "Nume Complet", lbl_phone: "Telefon", lbl_email: "Email", lbl_msg: "Cum te putem ajuta?", btn_send: "Trimite Mesaj",
            
            chat_title: "Asistent One Guide",
            ph_ask: "Pune o întrebare...",
            btn_send_chat: "Trimite",
            chat_welcome: "Salut! 👋 Te pot ajuta să găsești un curs sau să contactezi un consilier.",
            chat_finance: "Suntem specializați în **Student Finance England**. Poți primi până la £15,000/an.",
            chat_courses: "Oferim cursuri în **Afaceri, Sănătate, IT, Drept și Arte**.",
            chat_contact: "Ne poți contacta prin formular. Răspundem în 24 de ore.",
            chat_fallback: "Te pot ajuta cu **Cursuri**, **Finanțare**, sau **Admiteri**."
        },
        pl: {
            nav_courses: "Kursy", nav_team: "Zespół", nav_reviews: "Opinie", nav_contact: "Kontakt", nav_prep: "Przygotowanie", nav_tagline: "Pomożemy Ci znaleźć właściwy kierunek",
            hero_h1_1: "Szkolnictwo Wyższe &", hero_h1_2: "Ścieżki Zawodowe", hero_sub: "Eksperckie doradztwo w rekrutacji na studia.",
            search_title: "Szukaj Kursów", lbl_postcode: "Miasto", lbl_level: "Poziom", lbl_subject: "Kierunek", lbl_travel: "Dojazd", btn_find: "Szukaj",
            leader_title: "Nasze Kierownictwo", leader_role: "Lider Zespołu", leader_desc: "Ekspert ds. rekrutacji i finansowania studiów w UK.", btn_view: "Zobacz Profil",
            team_title: "Poznaj Zespół", team_sub: "Eksperccy doradcy dedykowani Twojej podróży.",
            role_finance: "Ekspert Finansowy", desc_alexandra: "Specjalizuje się w odwołaniach SFE.",
            role_social: "Opieka Społeczna", desc_carmen: "Ekspert w rekrutacji na zdrowie.",
            role_eligibility: "Ekspert Kwalifikowalności", desc_ovidiu: "Zapewnia zgodność statusu rezydenta.",
            role_app: "Specjalista Aplikacji", desc_georgiana: "Upraszcza proces aplikacji.",
            role_advisor: "Doradca Studenta", desc_valentina: "Wsparcie dla studentów dojrzałych.",
            role_enroll: "Urzędnik Rekrutacji", desc_madalina: "Specjalista procedur rekrutacyjnych.",
            role_multi: "Doradca Wielojęzyczny", desc_timis: "Biegły w 4 językach.",
            role_statement: "Ekspert Oświadczeń", desc_laurentiu: "Pisanie oświadczeń osobistych.",
            role_guide: "Przewodnik Akademicki", desc_alina: "Szczegółowe porady akademickie.",
            role_recruit: "Rekrutacja", desc_join: "Rozpocznij karierę doradcy.",
            desc_andreea: "Spokojne, cierpliwe i spersonalizowane wsparcie.",
            prep_title: "Przygotowanie do Rozmowy", star_t: "Metoda STAR", star_d: "Pytania behawioralne.", psych_t: "Ocena Umiejętności", psych_d: "Logika i rozumowanie.", case_t: "Studia Przypadku", case_d: "Rzeczywiste scenariusze.",
            rev_title: "Opinie Studentów", rev_leave: "Zostaw Opinię", ph_name: "Twoje Imię", ph_comment: "Komentarz", btn_post: "Opublikuj",
            contact_title: "Skontaktuj się", contact_sub: "Zacznij akademicką podróż już dziś.",
            lbl_name: "Imię i Nazwisko", lbl_phone: "Telefon", lbl_email: "Email", lbl_msg: "W czym pomóc?", btn_send: "Wyślij Wiadomość",
            
            chat_title: "Asystent One Guide",
            ph_ask: "Zadaj pytanie...",
            btn_send_chat: "Wyślij",
            chat_welcome: "Cześć! 👋 Mogę pomóc znaleźć kurs lub skontaktować się z doradcą.",
            chat_finance: "Specjalizujemy się w **Student Finance England**. Do £15,000/rok.",
            chat_courses: "Oferujemy kursy: **Biznes, Zdrowie, IT, Prawo i Sztuka**.",
            chat_contact: "Skontaktuj się z nami przez formularz. Odpowiadamy w 24h.",
            chat_fallback: "Mogę pomóc z **Kursami**, **Finansami** lub **Rekrutacją**."
        },
        hu: {
            nav_courses: "Tanfolyamok", nav_team: "Csapat", nav_reviews: "Vélemények", nav_contact: "Kapcsolat", nav_prep: "Felkészülés", nav_tagline: "Segítünk megtalálni a helyes irányt",
            hero_h1_1: "Felsőoktatás és", hero_h1_2: "Szakmai Utak", hero_sub: "Szakértői útmutatás az egyetemi felvételihez.",
            search_title: "Tanfolyamok", lbl_postcode: "Város", lbl_level: "Szint", lbl_subject: "Tárgy", lbl_travel: "Utazás", btn_find: "Keresés",
            leader_title: "Vezetőségünk", leader_role: "Csapatvezető", leader_desc: "Egyesült Királyságbeli felvételi és diákfinanszírozási szakértő.", btn_view: "Profil Megtekintése",
            team_title: "Ismerje meg a Csapatot", team_sub: "Szakértő tanácsadók az Ön szolgálatában.",
            role_finance: "Pénzügyi Szakértő", desc_alexandra: "SFE fellebbezésekre specializálódott.",
            role_social: "Szociális Munkás", desc_carmen: "Egészségügyi felvételi szakértő.",
            role_eligibility: "Jogosultsági Szakértő", desc_ovidiu: "Ellenőrzi a tartózkodási státuszt.",
            role_app: "Jelentkezési Szakértő", desc_georgiana: "Egyszerűsíti a jelentkezést.",
            role_advisor: "Diáktanácsadó", desc_valentina: "Támogatás érett diákoknak.",
            role_enroll: "Beiratkozási Tisztviselő", desc_madalina: "Beiratkozási eljárások szakértője.",
            role_multi: "Többnyelvű Tanácsadó", desc_timis: "4 nyelven beszél folyékonyan.",
            role_statement: "Nyilatkozat Szakértő", desc_laurentiu: "Személyes nyilatkozatok írása.",
            role_guide: "Akadémiai Útmutató", desc_alina: "Részletes tanulmányi útmutatás.",
            role_recruit: "Toborzás", desc_join: "Kezdje karrierjét nálunk.",
            desc_andreea: "Nyugodt, türelmes és személyre szabott támogatás.",
            prep_title: "Interjú Felkészülés", star_t: "STAR Módszer", star_d: "Viselkedési kérdések.", psych_t: "Képességfelmérés", psych_d: "Logikai gyakorlat.", case_t: "Esettanulmányok", case_d: "Valós forgatókönyvek.",
            rev_title: "Diák Vélemények", rev_leave: "Írjon Véleményt", ph_name: "Neve", ph_comment: "Megjegyzés", btn_post: "Közzététel",
            contact_title: "Lépjen Kapcsolatba", contact_sub: "Kezdje el akadémiai útját ma.",
            lbl_name: "Teljes Név", lbl_phone: "Telefon", lbl_email: "Email", lbl_msg: "Miben segíthetünk?", btn_send: "Üzenet Küldése",
            
            chat_title: "One Guide Asszisztens",
            ph_ask: "Kérdezzen valamit...",
            btn_send_chat: "Küldés",
            chat_welcome: "Szia! 👋 Segíthetek kurzust találni vagy tanácsadót elérni.",
            chat_finance: "Specialitásunk a **Student Finance England**. Akár £15,000/év.",
            chat_courses: "Kurzusaink: **Üzlet, Egészségügy, IT, Jog és Művészet**.",
            chat_contact: "Írjon nekünk az űrlapon keresztül. 24 órán belül válaszolunk.",
            chat_fallback: "Segíthetek **Kurzusokkal**, **Pénzügyekkel** vagy **Felvételivel** kapcsolatban."
        },
        es: {
            nav_courses: "Cursos", nav_team: "Equipo", nav_reviews: "Reseñas", nav_contact: "Contacto", nav_prep: "Preparación", nav_tagline: "Te ayudamos a encontrar el camino correcto",
            hero_h1_1: "Educación Superior y", hero_h1_2: "Caminos Profesionales", hero_sub: "Orientación experta en admisiones universitarias.",
            search_title: "Buscar Cursos", lbl_postcode: "Ciudad", lbl_level: "Nivel", lbl_subject: "Tema", lbl_travel: "Viaje", btn_find: "Buscar",
            leader_title: "Nuestro Liderazgo", leader_role: "Líder de Equipo", leader_desc: "Experta en admisiones y financiación estudiantil en el Reino Unido.", btn_view: "Ver Perfil",
            team_title: "Conoce al Equipo", team_sub: "Asesores expertos dedicados a tu viaje.",
            role_finance: "Experto Financiero", desc_alexandra: "Especialista en apelaciones SFE.",
            role_social: "Trabajo Social", desc_carmen: "Experta en admisiones de Salud.",
            role_eligibility: "Experto Elegibilidad", desc_ovidiu: "Asegura el estatus de residencia.",
            role_app: "Especialista Aplicaciones", desc_georgiana: "Simplifica el proceso de solicitud.",
            role_advisor: "Asesor Estudiantil", desc_valentina: "Apoyo a estudiantes maduros.",
            role_enroll: "Oficial de Inscripción", desc_madalina: "Especialista en procedimientos.",
            role_multi: "Asesor Multilingüe", desc_timis: "Fluido en 4 idiomas.",
            role_statement: "Experto Declaraciones", desc_laurentiu: "Redacción de declaraciones personales.",
            role_guide: "Guía Académico", desc_alina: "Proporciona orientación académica.",
            role_recruit: "Reclutamiento", desc_join: "Comienza tu carrera hoy.",
            desc_andreea: "Apoyo tranquilo, paciente y personalizado.",
            prep_title: "Preparación Entrevista", star_t: "Método STAR", star_d: "Preguntas de comportamiento.", psych_t: "Evaluación de Capacidad", psych_d: "Lógica y razonamiento.", case_t: "Casos de Estudio", case_d: "Escenarios reales.",
            rev_title: "Reseñas de Estudiantes", rev_leave: "Dejar una Reseña", ph_name: "Tu Nombre", ph_comment: "Comentario", btn_post: "Publicar",
            contact_title: "Ponte en Contacto", contact_sub: "Comienza tu viaje académico hoy.",
            lbl_name: "Nombre Completo", lbl_phone: "Teléfono", lbl_email: "Email", lbl_msg: "¿Cómo ayudar?", btn_send: "Enviar Mensaje",
            
            chat_title: "Asistente One Guide",
            ph_ask: "Haz una pregunta...",
            btn_send_chat: "Enviar",
            chat_welcome: "¡Hola! 👋 Puedo ayudarte a encontrar un curso o contactar a un asesor.",
            chat_finance: "Nos especializamos en **Student Finance England**. Hasta £15,000/año.",
            chat_courses: "Ofrecemos grados en **Negocios, Salud, IT, Derecho y Artes**.",
            chat_contact: "Contáctanos mediante el formulario. Respondemos en 24h.",
            chat_fallback: "Puedo ayudarte con **Cursos**, **Finanzas**, o **Admisiones**."
        },
        it: {
            nav_courses: "Corsi", nav_team: "Team", nav_reviews: "Recensioni", nav_contact: "Contatti", nav_prep: "Preparazione", nav_tagline: "Ti aiutiamo a trovare la strada giusta",
            hero_h1_1: "Istruzione Superiore &", hero_h1_2: "Percorsi Professionali", hero_sub: "Guida esperta per le ammissioni universitarie.",
            search_title: "Cerca Corsi", lbl_postcode: "Città", lbl_level: "Livello", lbl_subject: "Materia", lbl_travel: "Viaggio", btn_find: "Cerca",
            leader_title: "La Nostra Leadership", leader_role: "Team Leader", leader_desc: "Esperta in ammissioni e finanziamenti agli studi nel Regno Unito.", btn_view: "Vedi Profilo",
            team_title: "Incontra il Team", team_sub: "Consulenti esperti dedicati al tuo viaggio.",
            role_finance: "Esperto Finanza", desc_alexandra: "Specialista in ricorsi SFE.",
            role_social: "Assistente Sociale", desc_carmen: "Esperta in ammissioni sanitarie.",
            role_eligibility: "Esperto Idoneità", desc_ovidiu: "Verifica lo stato di residenza.",
            role_app: "Specialista Domande", desc_georgiana: "Semplifica la domanda universitaria.",
            role_advisor: "Consulente Studenti", desc_valentina: "Supporto per studenti maturi.",
            role_enroll: "Ufficiale Iscrizioni", desc_madalina: "Specialista in procedure.",
            role_multi: "Consulente Multilingue", desc_timis: "Parla 4 lingue.",
            role_statement: "Esperto Dichiarazioni", desc_laurentiu: "Scrittura di Personal Statements.",
            role_guide: "Guida Accademica", desc_alina: "Fornisce orientamento dettagliato.",
            role_recruit: "Reclutamento", desc_join: "Inizia la tua carriera oggi.",
            desc_andreea: "Supporto calmo, paziente e personalizzato.",
            prep_title: "Preparazione Colloquio", star_t: "Metodo STAR", star_d: "Domande comportamentali.", psych_t: "Valutazione Abilità", psych_d: "Logica e ragionamento.", case_t: "Casi Studio", case_d: "Scenari reali.",
            rev_title: "Recensioni Studenti", rev_leave: "Lascia una Recensione", ph_name: "Il Tuo Nome", ph_comment: "Commento", btn_post: "Pubblica",
            contact_title: "Contattaci", contact_sub: "Inizia il tuo viaggio accademico oggi.",
            lbl_name: "Nome Completo", lbl_phone: "Telefono", lbl_email: "Email", lbl_msg: "Come aiutare?", btn_send: "Invia Messaggio",
            
            chat_title: "Assistente One Guide",
            ph_ask: "Fai una domanda...",
            btn_send_chat: "Invia",
            chat_welcome: "Ciao! 👋 Posso aiutarti a trovare un corso o contattare un consulente.",
            chat_finance: "Siamo specializzati in **Student Finance England**. Fino a £15,000/anno.",
            chat_courses: "Offriamo corsi in **Business, Salute, IT, Legge e Arti**.",
            chat_contact: "Contattaci tramite il modulo. Rispondiamo in 24 ore.",
            chat_fallback: "Posso aiutarti con **Corsi**, **Finanza**, o **Ammissioni**."
        },
        pt: {
            nav_courses: "Cursos", nav_team: "Equipe", nav_reviews: "Avaliações", nav_contact: "Contato", nav_prep: "Preparação", nav_tagline: "Ajudamos você a encontrar o caminho certo",
            hero_h1_1: "Ensino Superior &", hero_h1_2: "Caminhos Profissionais", hero_sub: "Orientação especializada em admissões universitárias.",
            search_title: "Buscar Cursos", lbl_postcode: "Cidade", lbl_level: "Nível", lbl_subject: "Assunto", lbl_travel: "Viagem", btn_find: "Buscar",
            leader_title: "Nossa Liderança", leader_role: "Líder de Equipe", leader_desc: "Especialista em admissões e financiamento estudantil no Reino Unido.", btn_view: "Ver Perfil",
            team_title: "Conheça a Equipe", team_sub: "Consultores especializados dedicados à sua jornada.",
            role_finance: "Especialista Financeiro", desc_alexandra: "Especialista em apelos SFE.",
            role_social: "Assistente Social", desc_carmen: "Especialista em admissões de Saúde.",
            role_eligibility: "Especialista Elegibilidade", desc_ovidiu: "Garante status de residência.",
            role_app: "Especialista Aplicações", desc_georgiana: "Simplifica o processo de aplicação.",
            role_advisor: "Consultor Estudantil", desc_valentina: "Apoio a estudantes maduros.",
            role_enroll: "Oficial de Matrícula", desc_madalina: "Especialista em procedimentos.",
            role_multi: "Consultor Multilíngue", desc_timis: "Fluente em 4 idiomas.",
            role_statement: "Especialista Declarações", desc_laurentiu: "Redação de Personal Statements.",
            role_guide: "Guia Acadêmico", desc_alina: "Fornece orientação detalhada.",
            role_recruit: "Recrutamento", desc_join: "Comece sua carreira hoje.",
            desc_andreea: "Apoio calmo, paciente e personalizado.",
            prep_title: "Preparação Entrevista", star_t: "Método STAR", star_d: "Questões comportamentais.", psych_t: "Avaliação de Capacidade", psych_d: "Lógica e raciocínio.", case_t: "Estudos de Caso", case_d: "Cenários reais.",
            rev_title: "Avaliações", rev_leave: "Deixe uma Avaliação", ph_name: "Seu Nome", ph_comment: "Comentário", btn_post: "Publicar",
            contact_title: "Entre em Contato", contact_sub: "Comece sua jornada acadêmica hoje.",
            lbl_name: "Nome", lbl_phone: "Telefone", lbl_email: "Email", lbl_msg: "Como ajudar?", btn_send: "Enviar Mensagem",
            
            chat_title: "Assistente One Guide",
            ph_ask: "Faça uma pergunta...",
            btn_send_chat: "Enviar",
            chat_welcome: "Olá! 👋 Posso ajudar a encontrar um curso ou falar com um consultor.",
            chat_finance: "Especialistas em **Student Finance England**. Até £15,000/ano.",
            chat_courses: "Oferecemos cursos em **Negócios, Saúde, TI, Direito e Artes**.",
            chat_contact: "Contate-nos pelo formulário. Respondemos em 24h.",
            chat_fallback: "Posso ajudar com **Cursos**, **Financiamento**, ou **Admissões**."
        },
        el: {
            nav_courses: "Μαθήματα", nav_team: "Ομάδα", nav_reviews: "Κριτικές", nav_contact: "Επαφή", nav_prep: "Προετοιμασία", nav_tagline: "Σας βοηθάμε να βρείτε τη σωστή κατεύθυνση",
            hero_h1_1: "Τριτοβάθμια Εκπαίδευση &", hero_h1_2: "Επαγγελματικά Μονοπάτια", hero_sub: "Εξειδικευμένη καθοδήγηση για εισαγωγές.",
            search_title: "Αναζήτηση", lbl_postcode: "Πόλη", lbl_level: "Επίπεδο", lbl_subject: "Θέμα", lbl_travel: "Ταξίδι", btn_find: "Εύρεση",
            leader_title: "Η Ηγεσία μας", leader_role: "Αρχηγός Ομάδας", leader_desc: "Ειδικός στις εισαγωγές και τη φοιτητική χρηματοδότηση στο Η.Β.", btn_view: "Προφίλ",
            team_title: "Γνωρίστε την Ομάδα", team_sub: "Εξειδικευμένοι σύμβουλοι για το ταξίδι σας.",
            role_finance: "Ειδικός Οικονομικών", desc_alexandra: "Ειδικεύεται στις προσφυγές SFE.",
            role_social: "Κοινωνικός Λειτουργός", desc_carmen: "Ειδικός στις εισαγωγές Υγείας.",
            role_eligibility: "Ειδικός Επιλεξιμότητας", desc_ovidiu: "Διασφαλίζει το καθεστώς διαμονής.",
            role_app: "Ειδικός Αιτήσεων", desc_georgiana: "Απλοποιεί τη διαδικασία αίτησης.",
            role_advisor: "Σύμβουλος Φοιτητών", desc_valentina: "Υποστήριξη για ώριμους φοιτητές.",
            role_enroll: "Υπεύθυνος Εγγραφών", desc_madalina: "Ειδικός στις διαδικασίες εγγραφής.",
            role_multi: "Πολύγλωσσος Σύμβουλος", desc_timis: "Μιλάει 4 γλώσσες.",
            role_statement: "Ειδικός Δηλώσεων", desc_laurentiu: "Σύνταξη προσωπικών δηλώσεων.",
            role_guide: "Ακαδημαϊκός Οδηγός", desc_alina: "Παρέχει λεπτομερή καθοδήγηση.",
            role_recruit: "Στελέχωση", desc_join: "Ξεκινήστε την καριέρα σας σήμερα.",
            desc_andreea: "Ήρεμη και εξατομικευμένη υποστήριξη.",
            prep_title: "Προετοιμασία Συνέντευξης", star_t: "Μέθοδος STAR", star_d: "Ερωτήσεις συμπεριφοράς.", psych_t: "Αξιολόγηση Ικανοτήτων", psych_d: "Λογική και συλλογισμός.", case_t: "Μελέτες Περίπτωσης", case_d: "Πραγματικά σενάρια.",
            rev_title: "Κριτικές", rev_leave: "Αφήστε Κριτική", ph_name: "Όνομα", ph_comment: "Σχόλιο", btn_post: "Δημοσίευση",
            contact_title: "Επικοινωνήστε", contact_sub: "Ξεκινήστε το ταξίδι σας σήμερα.",
            lbl_name: "Όνομα", lbl_phone: "Τηλέφωνο", lbl_email: "Email", lbl_msg: "Πώς μπορούμε να βοηθήσουμε;", btn_send: "Αποστολή",
            
            chat_title: "Βοηθός One Guide",
            ph_ask: "Κάντε μια ερώτηση...",
            btn_send_chat: "Αποστολή",
            chat_welcome: "Γεια σας! 👋 Μπορώ να βοηθήσω στην εύρεση μαθήματος.",
            chat_finance: "Ειδικευόμαστε στο **Student Finance England**. Έως £15,000/έτος.",
            chat_courses: "Προσφέρουμε πτυχία σε **Επιχειρήσεις, Υγεία, Πληροφορική**.",
            chat_contact: "Επικοινωνήστε μαζί μας μέσω της φόρμας.",
            chat_fallback: "Μπορώ να βοηθήσω με **Μαθήματα**, **Οικονομικά**, ή **Εισαγωγές**."
        },
        bg: {
            nav_courses: "Курсове", nav_team: "Екип", nav_reviews: "Отзиви", nav_contact: "Контакт", nav_prep: "Подготовка", nav_tagline: "Помагаме ви да намерите правилната посока",
            hero_h1_1: "Висше Образование &", hero_h1_2: "Професионални Пътища", hero_sub: "Експертни насоки за университетски прием.",
            search_title: "Търсене", lbl_postcode: "Град", lbl_level: "Ниво", lbl_subject: "Предмет", lbl_travel: "Пътуване", btn_find: "Търси",
            leader_title: "Нашето Ръководство", leader_role: "Ръководител", leader_desc: "Експерт по прием и студентско финансиране във Великобритания.", btn_view: "Виж Профил",
            team_title: "Запознайте се с Екипа", team_sub: "Експертни съветници, посветени на вашето пътуване.",
            role_finance: "Финансов Експерт", desc_alexandra: "Специалист по обжалвания SFE.",
            role_social: "Социален Работник", desc_carmen: "Експерт по прием в Здравеопазване.",
            role_eligibility: "Експерт Допустимост", desc_ovidiu: "Гарантира статут на пребиваване.",
            role_app: "Специалист Кандидатстване", desc_georgiana: "Опростява процеса на кандидатстване.",
            role_advisor: "Студентски Съветник", desc_valentina: "Подкрепа за зрели студенти.",
            role_enroll: "Служител Записване", desc_madalina: "Специалист по процедури.",
            role_multi: "Многоезичен Съветник", desc_timis: "Владее 4 езика.",
            role_statement: "Експерт Есета", desc_laurentiu: "Писане на лични изявления.",
            role_guide: "Академичен Ръководител", desc_alina: "Предоставя подробни насоки.",
            role_recruit: "Набиране", desc_join: "Започнете кариерата си днес.",
            desc_andreea: "Спокойна и персонализирана подкрепа.",
            prep_title: "Подготовка за Интервю", star_t: "Метод STAR", star_d: "Поведенчески въпроси.", psych_t: "Оценка на Способности", psych_d: "Логика и разсъждение.", case_t: "Казуси", case_d: "Реални сценарии.",
            rev_title: "Отзиви", rev_leave: "Оставете Отзив", ph_name: "Име", ph_comment: "Коментар", btn_post: "Публикувай",
            contact_title: "Свържете се с нас", contact_sub: "Започнете академичното си пътуване.",
            lbl_name: "Име", lbl_phone: "Телефон", lbl_email: "Имейл", lbl_msg: "Как да помогнем?", btn_send: "Изпрати",
            
            chat_title: "Асистент One Guide",
            ph_ask: "Задайте въпрос...",
            btn_send_chat: "Изпрати",
            chat_welcome: "Здравейте! 👋 Мога да помогна с намирането на курс.",
            chat_finance: "Специализираме в **Student Finance England**. До £15,000/година.",
            chat_courses: "Предлагаме степени по **Бизнес, Здравеопазване, IT**.",
            chat_contact: "Свържете се с нас чрез формата.",
            chat_fallback: "Мога да помогна с **Курсове**, **Финансиране**, или **Прием**."
        }
    };
    
    function setLang(lang) {
        const t = translations[lang] || translations['en'];
        document.querySelectorAll('[data-key]').forEach(el => {
            const key = el.getAttribute('data-key');
            if(t[key]) {
                if(el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') el.placeholder = t[key];
                else el.textContent = t[key];
            }
        });
        const chatMsg = document.querySelector('.msg.bot');
        if(chatMsg && document.getElementById('chat-messages').children.length === 1) {
            chatMsg.innerHTML = t['chat_welcome'] || translations['en']['chat_welcome'];
        }
    }

async function handleSearch(e) {
        e.preventDefault();
        
        const userLocation = document.getElementById('user-postcode').value.trim().toLowerCase();
        const userMode = document.getElementById('user-mode') ? document.getElementById('user-mode').value : 'All';
        const userLevel = document.getElementById('user-level').value;
        const userSubject = document.getElementById('user-subject').value;
        
        const div = document.getElementById('results-area');
        const spinner = document.getElementById('loading-spinner');
        const pagControls = document.getElementById('pagination-controls');

        if(!userLocation && userMode !== 'Online' && userMode !== 'All') {
            return alert("Please enter a City or select 'Online' as your study mode.");
        }

        div.innerHTML = '';
        spinner.classList.remove('hidden');
        if(pagControls) pagControls.classList.add('hidden');
        allSortedResults = []; 

        setTimeout(() => {
            let rawResults = coursesDB.filter(course => {
                
                const dbMode = (course.mode || course.study_program || course.title || "").toLowerCase();
                let isModeMatch = true;
                
                if (userMode === "Campus") {
                    isModeMatch = !dbMode.includes("online") && !dbMode.includes("distance") && !dbMode.includes("self");
                } else if (userMode === "Online") {
                    isModeMatch = dbMode.includes("online") || dbMode.includes("distance") || dbMode.includes("self");
                }

                let isLocationMatch = true;
                if (userLocation !== "" && userMode !== "Online") {
                    const courseCity = (course.city || "").toLowerCase();
                    const courseAddress = (course.address || "").toLowerCase();
                    isLocationMatch = courseCity.includes(userLocation) || courseAddress.includes(userLocation);
                }

                const dbLevel = (course.level || "").toLowerCase();
                const selLevel = userLevel.toLowerCase();
                const isLevelMatch = (userLevel === 'All') || 
                                     (dbLevel.includes(selLevel)) || 
                                     (selLevel === "year 1" && dbLevel.includes("level 4")) ||
                                     (selLevel === "year 2" && dbLevel.includes("level 5")) ||
                                     (selLevel === "top-up" && dbLevel.includes("level 6")) ||
                                     (selLevel === "master" && (dbLevel.includes("master") || dbLevel.includes("level 7")));

                const isSubjectMatch = (userSubject === 'All') || (course.subject === userSubject);

                return isLocationMatch && isLevelMatch && isSubjectMatch && isModeMatch;
            });

            const seen = new Set();
            allSortedResults = rawResults.filter(course => {
                const courseTitle = course.title || course.courses[0] || "Course";
                const courseCity = course.city || "Campus";
                const uniqueKey = `${courseTitle.toLowerCase()}-${course.level}-${courseCity.toLowerCase()}`;
                
                if (seen.has(uniqueKey)) {
                    return false;
                } else {
                    seen.add(uniqueKey);
                    return true;
                }
            });

            spinner.classList.add('hidden');

            if (allSortedResults.length > 0) {
                currentPage = 1;
                renderPage(1);
            } else {
                div.innerHTML = `
                <div class="p-6 bg-white border border-gray-200 rounded-xl text-center text-gray-500">
                    <p class="font-bold text-lg mb-2">No courses found matching your criteria.</p>
                    <p class="text-sm">Try adjusting your filters, searching for a different city, or selecting Online learning.</p>
                </div>`;
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
                            <span class="text-[10px] font-bold text-white bg-blue-600 px-2 py-1 rounded-full uppercase tracking-wide">Accredited Course</span>
                            <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-full border border-blue-100">${c.level || 'Degree'}</span>
                        </div>
                        <h4 class="font-bold text-lg text-slate-800 group-hover:text-blue-600 transition">${courseTitle}</h4>
                        <div class="text-xs text-slate-500 mt-3 flex flex-wrap gap-4">
                            <span class="flex items-center gap-1.5"><i data-feather="map-pin" class="w-3 h-3 text-red-500"></i> ${c.city || 'Campus'}</span>
                            <span class="flex items-center gap-1.5"><i data-feather="book-open" class="w-3 h-3 text-blue-500"></i> ${c.subject || 'General'}</span>
                        </div>
                    </div>
                    <div class="text-right sm:text-right w-full sm:w-auto flex flex-row sm:flex-col items-center sm:items-end justify-between border-t sm:border-0 pt-3 sm:pt-0 border-slate-100 mt-2 sm:mt-0">
                        <div class="mb-0 sm:mb-3 text-left sm:text-right"><span class="block text-lg font-bold text-emerald-600">Available</span></div>
                        <a href="#contact" onclick="document.querySelector('textarea[name=\\'message\\']').value = 'I am interested in applying for: ${safeTitle} (${c.level}). Please contact me details.';" class="btn-primary text-xs px-6 py-2 shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5">Apply Now</a>
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

    function toggleChat() { 
        const w = document.getElementById('chat-window'); 
        w.style.display = w.style.display === 'flex' ? 'none' : 'flex'; 
    }
    
    function sendChat() {
        const input = document.getElementById('chat-input');
        const msg = input.value.trim().toLowerCase();
        if(!msg) return;
        
        const box = document.getElementById('chat-messages');
        box.innerHTML += `<div class="msg user">${input.value}</div>`;
        input.value = '';
        
        setTimeout(() => {
            let reply = "I'm not sure about that. Could you ask in a different way?";
            let actionBtn = "";
            if (msg.includes('finance') || msg.includes('money') || msg.includes('loan')) {
                reply = "We specialize in **Student Finance England**. You can get up to £15,000/year.";
                actionBtn = `<a href="#contact" class="chat-action-btn" onclick="toggleChat()">Contact Expert</a>`;
            } else if (msg.includes('course') || msg.includes('university')) {
                reply = "We offer degrees in Business, Health, Computing, Law & Arts.";
                actionBtn = `<a href="#course-search" class="chat-action-btn" onclick="toggleChat()">Search Courses</a>`;
            }
            box.innerHTML += `<div class="msg bot">${reply} ${actionBtn}</div>`;
            box.scrollTop = box.scrollHeight;
            feather.replace();
        }, 600);
    }

    let angle = 0, timer;
    const spinner = document.getElementById('carousel');
    function spin() { if(window.innerWidth > 1024 && spinner) { angle -= 0.1; spinner.style.transform = `rotateY(${angle}deg)`; } }
    function rotateCarousel(dir) {
        if(!spinner) return;
        clearInterval(timer);
        let currentRotation = angle;
        let targetAngle = Math.round(currentRotation / 32.7) * 32.7 + (dir * -32.7);
        angle = targetAngle;
        spinner.style.transition = 'transform 1s cubic-bezier(0.2,0.8,0.2,1)';
        spinner.style.transform = `rotateY(${angle}deg)`;
        setTimeout(() => { spinner.style.transition = 'none'; timer = setInterval(spin, 20); }, 1000);
    }
    window.onload = () => { timer = setInterval(spin, 20); };

    let currentRating = 0;
    function highlightStars(n) { document.querySelectorAll('.star-icon').forEach((s, i) => { if(i<n) s.classList.add('hovered'); else s.classList.remove('hovered'); }); }
    function resetStars() { document.querySelectorAll('.star-icon').forEach(s => s.classList.remove('hovered')); }
    function setRating(n) { currentRating = n; document.querySelectorAll('.star-icon').forEach((s, i) => { if(i<n) s.classList.add('active'); else s.classList.remove('active'); }); }

    async function handleReviewSubmit(e) {
        e.preventDefault();
        if(!currentRating) return alert("Select rating");
        const name = document.getElementById('review-name').value;
        const text = document.getElementById('review-text').value;
        const formData = new FormData();
        formData.append('action', 'submit_review');
        formData.append('name', name);
        formData.append('rating', currentRating);
        formData.append('text', text);
        try {
            const res = await fetch('index.php', { method: 'POST', body: formData });
            const data = await res.json();
            if(data.status === 'success') {
                alert('Review saved!');
                document.getElementById('reviews-container').innerHTML = data.reviews.map(renderReview).join('');
                e.target.reset(); currentRating = 0; document.querySelectorAll('.star-icon').forEach(s => s.classList.remove('active'));
            }
        } catch(err) { console.error(err); }
    }
    function renderReview(x) { return `<div class="bg-gray-50 p-6 rounded-lg shadow-sm border border-gray-200"><div class="flex justify-between font-bold text-slate-900"><span>${x.name}</span><span class="text-amber-500">★ ${x.rating}</span></div><p class="text-sm text-slate-600 mt-2">"${x.text}"</p></div>`; }
    function loadReviews() { 
    const c = document.getElementById('reviews-container'); 
    if(serverReviews.length) {
        c.innerHTML = serverReviews.map(renderReview).join(''); 
    } else { 
        c.innerHTML = '<p class="text-center text-slate-500" data-key="msg_no_reviews">No reviews yet.</p>'; 
    } 
}

    </script>
</body>
</html>
