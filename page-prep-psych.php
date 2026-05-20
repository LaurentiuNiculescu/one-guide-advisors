<?php
/*
*/

$web3FormsKey = "{your api here}"; 

?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interview Prep | Psychometric Tests</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #1e3a8a; /* Oxford Blue */
            --secondary: #b45309; /* Academic Gold */
            --panel-bg: rgba(255, 255, 255, 0.98);
            --text-main: #1f2937;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --shadow-card: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --correct: #dcfce7;
            --wrong: #fee2e2;
            --transition: all 0.3s ease;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; scroll-behavior: smooth; }
        
        body { 
            background-image: linear-gradient(rgba(253, 251, 247, 0.9), rgba(253, 251, 247, 0.95)), url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');
            background-size: cover; background-attachment: fixed;
            color: var(--text-main); font-family: 'Lato', sans-serif;
            display: flex; flex-direction: column; min-height: 100vh; line-height: 1.6;
        }

        h1, h2, h3, h4, .brand-text { font-family: 'Playfair Display', serif; }

        .container { max-width: 1000px; margin: 0 auto; padding: 0 20px; }
        .hidden { display: none; }
        .fade-in { animation: fadeInUp 0.8s ease forwards; opacity: 0; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        .btn { padding: 12px 30px; border: none; border-radius: 4px; cursor: pointer; font-weight: 700; transition: var(--transition); display: inline-block; text-decoration: none; text-transform: uppercase; letter-spacing: 1px; font-size: 0.85rem; }
        .btn-primary { background-color: var(--primary); color: white; border: 1px solid var(--primary); }
        .btn-primary:hover { background-color: #172554; transform: translateY(-2px); box-shadow: var(--shadow-card); }
        .btn-outline { background: transparent; border: 1px solid var(--primary); color: var(--primary); display: flex; align-items: center; gap: 8px; }
        .btn-outline:hover { background: var(--primary); color: white; }

        nav { background: var(--panel-bg); border-bottom: 1px solid var(--border-color); position: sticky; top: 0; z-index: 1000; backdrop-filter: blur(10px); }
        nav .container { display: flex; justify-content: space-between; align-items: center; height: 90px; }
        
        .brand-col { display: flex; flex-direction: column; align-items: center; text-decoration: none; }
        .brand-logo { height: 45px; width: auto; margin-bottom: 2px; }
        .brand-text { font-size: 1rem; font-weight: 700; color: var(--primary); letter-spacing: 0.5px; }

        .desktop-menu { display: flex; align-items: center; gap: 25px; }
        .nav-link { text-decoration: none; color: var(--text-main); font-weight: 600; font-size: 0.9rem; transition: 0.3s; text-transform: uppercase; letter-spacing: 0.5px; }
        .nav-link:hover { color: var(--secondary); }

        .mobile-toggle { display: none; font-size: 1.5rem; color: var(--primary); cursor: pointer; background: none; border: none; }
        #mobile-menu { display: none; position: absolute; top: 90px; left: 0; width: 100%; background: white; border-bottom: 4px solid var(--secondary); padding: 20px; flex-direction: column; gap: 15px; box-shadow: var(--shadow-card); }
        #mobile-menu.active { display: flex; }
        .mobile-link { color: var(--text-main); text-decoration: none; font-weight: 700; font-size: 1.1rem; text-align: center; padding: 10px; border-bottom: 1px solid #eee; }

        .lang-container { position: relative; display: inline-block; }
        .lang-btn { background: white; border: 1px solid #cbd5e1; color: var(--text-main); padding: 8px 15px; border-radius: 20px; cursor: pointer; font-weight: bold; font-size: 0.9rem; display: flex; align-items: center; gap: 8px; transition: 0.3s; }
        .lang-btn:hover { border-color: var(--primary); color: var(--primary); }
        .lang-dropdown { display: none; position: absolute; right: 0; top: 45px; background: white; border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); width: 160px; z-index: 1001; overflow: hidden; animation: slideDown 0.3s ease forwards; border: 1px solid var(--border-color); }
        .lang-dropdown.active { display: block; }
        .lang-option { padding: 10px 15px; cursor: pointer; color: #333; font-size: 0.9rem; border-bottom: 1px solid #f0f0f0; transition: 0.2s; }
        .lang-option:hover { background: #f1f5f9; color: var(--primary); padding-left: 20px; }
        .mobile-lang-select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background: #f9f9f9; color: #333; margin-top: 10px; font-size: 1rem; }

        @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

        .hero { text-align: center; padding: 80px 0 60px; border-bottom: 1px solid var(--border-color); }
        .hero h1 { font-size: 3rem; margin-bottom: 15px; color: var(--primary); }
        .hero p { font-size: 1.2rem; color: var(--text-muted); max-width: 700px; margin: 0 auto; }

        /* CARDS & CONTENT */
        .card { background: var(--panel-bg); border: 1px solid var(--border-color); padding: 40px; border-radius: 8px; margin-bottom: 40px; box-shadow: var(--shadow-card); position: relative; }
        
        .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 30px; }
        .info-item { background: #fff; padding: 25px; border-radius: 6px; border: 1px solid var(--border-color); border-left: 4px solid var(--secondary); transition: 0.3s; }
        .info-item:hover { transform: translateY(-3px); box-shadow: var(--shadow-card); }
        .info-icon { font-size: 2rem; color: var(--primary); margin-bottom: 15px; }

        .scenario-box { background: #f8fafc; padding: 25px; border-radius: 6px; border: 1px solid var(--border-color); margin-top: 20px; }
        .scenario-title { font-weight: bold; color: var(--primary); margin-bottom: 10px; display: block; }
        .option-analysis { margin-top: 15px; display: grid; gap: 10px; }
        .analysis-item { padding: 10px; border-radius: 4px; font-size: 0.9rem; }
        .analysis-best { background: #f0fdf4; border-left: 4px solid #22c55e; }
        .analysis-worst { background: #fef2f2; border-left: 4px solid #ef4444; }

        .quiz-question { margin-bottom: 30px; border-bottom: 1px solid #e2e8f0; padding-bottom: 20px; }
        .quiz-question h4 { margin-bottom: 15px; color: var(--text-main); font-family: 'Lato', sans-serif; font-weight: 700; }
        .quiz-options { list-style: none; }
        .quiz-option { 
            padding: 15px; margin-bottom: 10px; background: white; border: 1px solid #cbd5e1; 
            border-radius: 4px; cursor: pointer; transition: 0.2s; display: flex; align-items: center; gap: 10px;
        }
        .quiz-option:hover { background: #eff6ff; border-color: var(--primary); }
        .quiz-option.correct { background-color: var(--correct); border-color: #22c55e; color: #14532d; }
        .quiz-option.wrong { background-color: var(--wrong); border-color: #ef4444; color: #7f1d1d; }
        .score-board { text-align: center; font-size: 1.5rem; font-weight: bold; color: var(--primary); margin-top: 20px; display: none; padding: 20px; background: #f0f9ff; border-radius: 8px; }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; color: white; font-size: 0.9rem; margin-bottom: 8px; font-weight: 700; }
        .form-input { width: 100%; padding: 14px; background: rgba(255,255,255,0.9); border: 1px solid transparent; border-radius: 4px; font-size: 1rem; transition: 0.3s; font-family: 'Lato', sans-serif; }
        .form-input:focus { outline: none; border-color: var(--secondary); box-shadow: 0 0 0 3px rgba(180, 83, 9, 0.3); }

        footer { background: #1e3a8a; color: white; padding: 40px 0; margin-top: auto; text-align: center; border-top: 4px solid var(--secondary); }
        footer a { color: var(--secondary); text-decoration: none; font-weight: bold; }
        footer a:hover { color: white; text-decoration: underline; }

        @media(max-width: 900px) {
            .desktop-menu { display: none; }
            .mobile-toggle { display: block; }
            .hero { padding: 50px 0; }
            .hero h1 { font-size: 2rem; }
            .card { padding: 25px; }
            .form-grid { grid-template-columns: 1fr; gap: 15px; }
        }
    </style>
</head>
<body>

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

            
            <div class="desktop-menu">
                <a href="<?php echo home_url(); ?>#course-search" class="nav-link" data-key="nav_courses">Courses</a>
                <a href="<?php echo home_url(); ?>#team" class="nav-link" data-key="nav_team">Advisors</a>
                <a href="<?php echo home_url(); ?>#reviews" class="nav-link" data-key="nav_reviews">Reviews</a>
                
                <div class="lang-container">
                    <div class="lang-btn" onclick="toggleLangMenu()">
                        <i class="fa-solid fa-globe"></i> <span id="current-lang">English</span> <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="lang-dropdown" id="lang-dropdown">
                        <div class="lang-option" onclick="setLang('en')">🇬🇧 English</div>
                        <div class="lang-option" onclick="setLang('ro')">🇷🇴 Română</div>
                        <div class="lang-option" onclick="setLang('pl')">🇵🇱 Polski</div>
                        <div class="lang-option" onclick="setLang('hu')">🇭🇺 Magyar</div>
                        <div class="lang-option" onclick="setLang('es')">🇪🇸 Español</div>
                        <div class="lang-option" onclick="setLang('it')">🇮🇹 Italiano</div>
                        <div class="lang-option" onclick="setLang('pt')">🇵🇹 Português</div>
                        <div class="lang-option" onclick="setLang('el')">🇬🇷 Ελληνικά</div>
                        <div class="lang-option" onclick="setLang('bg')">🇧🇬 Български</div>
                    </div>
                </div>

                <a href="#contact" class="btn btn-primary" style="padding: 8px 20px; font-size: 0.9rem;" data-key="nav_contact">Contact Us</a>
            </div>

            <button class="mobile-toggle" onclick="toggleMobileMenu()">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>

        <div id="mobile-menu">
            <a href="<?php echo home_url(); ?>#course-search" class="mobile-link" data-key="nav_courses">Courses</a>
            <a href="<?php echo home_url(); ?>#team" class="mobile-link" data-key="nav_team">Advisors</a>
            <a href="<?php echo home_url(); ?>#reviews" class="mobile-link" data-key="nav_reviews">Reviews</a>
            <a href="#contact" class="mobile-link" style="color: var(--primary);" data-key="nav_contact">Contact Us</a>
            
            <div style="margin-top: 15px; padding: 0 10px;">
                <label style="color: #666; font-size: 0.8rem; font-weight: bold; display:block; margin-bottom:5px;">SELECT LANGUAGE:</label>
                <select onchange="setLang(this.value); toggleMobileMenu();" class="mobile-lang-select">
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

    <header class="hero fade-in">
        <div class="container">
            <h1 data-key="hero_title">Situational Judgement Tests</h1>
            <p data-key="hero_desc">Master the art of decision making. Learn how to identify the most effective responses for university admissions assessments.</p>
        </div>
    </header>

    <main class="container fade-in" style="animation-delay: 0.2s;">
        
        <div class="card" style="margin-top: -40px;">
            <h2 data-key="intro_title" style="color:var(--primary); font-weight:700; margin-bottom:15px;">What are Psychometric Tests?</h2>
            <p style="color:var(--text-muted);" data-key="intro_text">Universities use Situational Judgement Tests (SJTs) to assess your soft skills. Unlike academic exams, there are no strict "right" or "wrong" answers, but there are definitely "effective" and "ineffective" ones.</p>
            
            <div class="info-grid">
                <div class="info-item">
                    <i class="fa-solid fa-scale-balanced info-icon"></i>
                    <h3 data-key="key_1_title">Integrity</h3>
                    <p style="font-size:0.9rem;" data-key="key_1_desc">Always choose the honest path. Never hide mistakes or cheat.</p>
                </div>
                <div class="info-item">
                    <i class="fa-solid fa-users info-icon"></i>
                    <h3 data-key="key_2_title">Teamwork</h3>
                    <p style="font-size:0.9rem;" data-key="key_2_desc">Prioritize the group's success. Resolve conflict calmly.</p>
                </div>
                <div class="info-item">
                    <i class="fa-solid fa-hand-holding-heart info-icon"></i>
                    <h3 data-key="key_3_title">Empathy</h3>
                    <p style="font-size:0.9rem;" data-key="key_3_desc">Consider how your actions affect others' feelings.</p>
                </div>
                <div class="info-item">
                    <i class="fa-solid fa-brain info-icon"></i>
                    <h3 data-key="key_4_title">Adaptability</h3>
                    <p style="font-size:0.9rem;" data-key="key_4_desc">Show you can handle stress and changing priorities.</p>
                </div>
            </div>
        </div>

        <div class="card">
            <h2 data-key="ex_title" style="color:var(--primary); font-weight:700; margin-bottom:15px;">How to Analyze a Scenario</h2>
            <p style="margin-bottom:20px;" data-key="ex_desc">You will be given a situation and asked to rank responses from <strong>Most Effective</strong> to <strong>Least Effective</strong>.</p>

            <div class="scenario-box">
                <span class="scenario-title" data-key="sc_title">SCENARIO:</span>
                <p data-key="sc_text">You are working on a group assignment. One member, Alex, has not attended meetings or contributed work. The deadline is tomorrow.</p>
                
                <div class="option-analysis">
                    <div class="analysis-item analysis-best">
                        <strong data-key="best_lbl">✅ Most Effective:</strong> <span data-key="best_txt">Speak to Alex privately to ask if there is a reason for the delay, then encourage him to contribute what he can. (Shows leadership & empathy).</span>
                    </div>
                    <div class="analysis-item">
                        <strong data-key="avg_lbl">⚠️ Average:</strong> <span data-key="avg_txt">Divide Alex's work among the rest of the group to ensure the project is finished on time. (Solves the problem, but ignores the team dynamic).</span>
                    </div>
                    <div class="analysis-item analysis-worst">
                        <strong data-key="worst_lbl">❌ Least Effective:</strong> <span data-key="worst_txt">Report Alex to the tutor immediately and demand he be removed from the group. (Aggressive & non-collaborative).</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <h2 style="text-align: center; margin-bottom: 30px; color:var(--primary); font-weight:700;"><i class="fa-solid fa-clipboard-question"></i> <span data-key="quiz_title">Practice Test</span></h2>
            
            <div id="quiz-container">
                
                <div class="quiz-question">
                    <h4 data-key="q1">1. You witness a fellow student cheating during an exam. What is the MOST effective action?</h4>
                    <ul class="quiz-options">
                        <li class="quiz-option" onclick="checkAnswer(this, false)"><span data-key="q1_a">A) Ignore it. It's not your business.</span></li>
                        <li class="quiz-option" onclick="checkAnswer(this, true)"><span data-key="q1_b">B) Inform the invigilator discreetly. (Integrity)</span></li>
                        <li class="quiz-option" onclick="checkAnswer(this, false)"><span data-key="q1_c">C) Confront the student loudly during the exam.</span></li>
                    </ul>
                </div>

                <div class="quiz-question">
                    <h4 data-key="q2">2. You have two urgent deadlines due on the same day. You are overwhelmed. What do you do?</h4>
                    <ul class="quiz-options">
                        <li class="quiz-option" onclick="checkAnswer(this, false)"><span data-key="q2_a">A) Rush both and submit lower quality work.</span></li>
                        <li class="quiz-option" onclick="checkAnswer(this, false)"><span data-key="q2_b">B) Submit one late without telling anyone.</span></li>
                        <li class="quiz-option" onclick="checkAnswer(this, true)"><span data-key="q2_c">C) Contact your tutors early to request an extension. (Communication)</span></li>
                    </ul>
                </div>

                <div class="quiz-question">
                    <h4 data-key="q3">3. A customer at your part-time job is angry about a mistake you didn't make. What do you do?</h4>
                    <ul class="quiz-options">
                        <li class="quiz-option" onclick="checkAnswer(this, true)"><span data-key="q3_a">A) Apologize for their experience and resolve the issue. (Professionalism)</span></li>
                        <li class="quiz-option" onclick="checkAnswer(this, false)"><span data-key="q3_b">B) Argue back and tell them it wasn't you.</span></li>
                        <li class="quiz-option" onclick="checkAnswer(this, false)"><span data-key="q3_c">C) Ignore them until they leave.</span></li>
                    </ul>
                </div>

            </div>

            <div id="score-board" class="score-board"></div>
            
            <div style="text-align: center; margin-top: 30px;">
                <p style="color:var(--text-muted); margin-bottom:15px;" data-key="cta_text">Want more complex scenarios?</p>
                <a href="#contact" class="btn btn-primary" data-key="cta_btn">Contact an Advisor</a>
            </div>
        </div>

        <div class="card" id="contact" style="background: var(--primary); color: white; border: none;">
            <h2 style="text-align:center; margin-bottom:20px; border-bottom: 2px solid rgba(255,255,255,0.2); padding-bottom:15px;">
                <i class="fa-solid fa-envelope"></i> <span data-key="form_header">Need help with Prep?</span>
            </h2>
            <p style="text-align:center; margin-bottom:30px; opacity:0.9;" data-key="form_sub">Contact us for personalized coaching.</p>
            
            <form action="https://api.web3forms.com/submit" method="POST">
                
                <input type="hidden" name="access_key" value="<?php echo $web3FormsKey; ?>">
                
                <input type="checkbox" name="botcheck" class="hidden" style="display: none;">

                <input type="hidden" name="subject" value="New Prep Inquiry (Psychometric)">
                <input type="hidden" name="from_name" value="One Guide Prep">

                <div class="form-grid">
                    <div class="form-group"><label class="form-label" data-key="lbl_name">Full Name</label><input type="text" name="name" class="form-input" required></div>
                    <div class="form-group"><label class="form-label" data-key="lbl_phone">Phone Number</label><input type="tel" name="phone" class="form-input" required></div>
                </div>
                <div class="form-group"><label class="form-label" data-key="lbl_email">Email Address</label><input type="email" name="email" class="form-input" required></div>
                <div class="form-group"><label class="form-label" data-key="lbl_msg">Questions / Goals</label><textarea name="message" rows="4" class="form-input" required></textarea></div>
                
                <button type="submit" class="btn" style="width: 100%; background: var(--secondary); color: white;" data-key="btn_send">Send Request</button>
            </form>
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
        function toggleMobileMenu() {
            document.getElementById('mobile-menu').classList.toggle('active');
        }

        function toggleLangMenu() {
            document.getElementById('lang-dropdown').classList.toggle('active');
        }

        const translations = {
            en: {
                nav_courses: "Courses", nav_team: "Advisors", nav_reviews: "Reviews", nav_contact: "Contact Us", nav_back: "Back Home",
                hero_title: "Situational Judgement Tests", hero_desc: "Master the art of decision making for university assessments.",
                intro_title: "What are Psychometric Tests?", intro_text: "Universities use SJTs to assess soft skills. There are no strict 'right' answers, but there are effective ones.",
                key_1_title: "Integrity", key_1_desc: "Always choose the honest path. Never hide mistakes.",
                key_2_title: "Teamwork", key_2_desc: "Prioritize the group's success. Resolve conflict calmly.",
                key_3_title: "Empathy", key_3_desc: "Consider how your actions affect others.",
                key_4_title: "Adaptability", key_4_desc: "Show you can handle stress and changing priorities.",
                ex_title: "How to Analyze a Scenario", ex_desc: "Rank responses from Most Effective to Least Effective.",
                sc_title: "SCENARIO:", sc_text: "You are working on a group assignment. One member, Alex, has not contributed. The deadline is tomorrow.",
                best_lbl: "✅ Most Effective:", best_txt: "Speak to Alex privately to ask if there is a reason for the delay. (Empathy)",
                avg_lbl: "⚠️ Average:", avg_txt: "Divide Alex's work among the group. (Solves problem, ignores dynamic)",
                worst_lbl: "❌ Least Effective:", worst_txt: "Report Alex immediately. (Aggressive)",
                quiz_title: "Practice Test",
                q1: "1. You witness a student cheating. What is the MOST effective action?", q1_a: "A) Ignore it.", q1_b: "B) Inform the invigilator discreetly.", q1_c: "C) Confront them loudly.",
                q2: "2. You have two urgent deadlines. What do you do?", q2_a: "A) Rush both.", q2_b: "B) Submit one late.", q2_c: "C) Request an extension early.",
                q3: "3. A customer is angry about a mistake you didn't make.", q3_a: "A) Apologize and resolve it.", q3_b: "B) Argue back.", q3_c: "C) Ignore them.",
                cta_text: "Want more complex scenarios?", cta_btn: "Contact an Advisor",
                form_header: "Need help with Prep?", form_sub: "Contact us for personalized coaching.",
                lbl_name: "Full Name", lbl_phone: "Phone Number", lbl_email: "Email Address", lbl_msg: "Questions / Goals", btn_send: "Send Request"
            },
            ro: {
                nav_courses: "Cursuri", nav_team: "Consilieri", nav_reviews: "Recenzii", nav_contact: "Contact", nav_back: "Înapoi Acasă",
                hero_title: "Teste de Judecată Situațională", hero_desc: "Stăpânește arta luării deciziilor pentru evaluările universitare.",
                intro_title: "Ce sunt Testele Psihometrice?", intro_text: "Universitățile folosesc SJT pentru a evalua abilitățile soft. Nu există răspunsuri strict 'corecte', ci eficiente.",
                key_1_title: "Integritate", key_1_desc: "Alege întotdeauna calea onestă.",
                key_2_title: "Muncă în echipă", key_2_desc: "Prioritizează succesul grupului.",
                key_3_title: "Empatie", key_3_desc: "Ia în considerare sentimentele altora.",
                key_4_title: "Adaptabilitate", key_4_desc: "Arată că poți gestiona stresul.",
                ex_title: "Analiza unui Scenariu", ex_desc: "Clasează răspunsurile de la Cel mai Eficient la Cel mai Puțin Eficient.",
                sc_title: "SCENARIU:", sc_text: "Lucrezi la un proiect de grup. Alex nu a contribuit. Termenul e mâine.",
                best_lbl: "✅ Cel mai Eficient:", best_txt: "Vorbește cu Alex în privat. (Empatie)",
                avg_lbl: "⚠️ Mediu:", avg_txt: "Împarte munca lui Alex la grup.",
                worst_lbl: "❌ Cel mai puțin Eficient:", worst_txt: "Raportează-l pe Alex imediat.",
                quiz_title: "Test de Practică",
                q1: "1. Vezi un student copiind. Ce faci?", q1_a: "A) Ignori.", q1_b: "B) Anunți supraveghetorul discret.", q1_c: "C) Îl confrunți.",
                q2: "2. Ai două termene limită urgente. Ce faci?", q2_a: "A) Te grăbești.", q2_b: "B) Predai unul târziu.", q2_c: "C) Cer o prelungire din timp.",
                q3: "3. Un client e supărat pe o greșeală care nu e a ta.", q3_a: "A) Rezolvi problema.", q3_b: "B) Te cerți.", q3_c: "C) Îl ignori.",
                cta_text: "Vrei scenarii mai complexe?", cta_btn: "Contactează un Consilier",
                form_header: "Ai nevoie de ajutor?", form_sub: "Contactează-ne pentru pregătire personalizată.",
                lbl_name: "Nume Complet", lbl_phone: "Telefon", lbl_email: "Email", lbl_msg: "Întrebări / Scopuri", btn_send: "Trimite Cerere"
            },
            pl: {
                nav_courses: "Kursy", nav_team: "Doradcy", nav_reviews: "Opinie", nav_contact: "Kontakt", nav_back: "Powrót",
                hero_title: "Testy Oceny Sytuacyjnej", hero_desc: "Opanuj sztukę podejmowania decyzji.",
                intro_title: "Czym są testy psychometryczne?", intro_text: "Uczelnie oceniają umiejętności miękkie. Nie ma złych odpowiedzi, są tylko mniej skuteczne.",
                key_1_title: "Uczciwość", key_1_desc: "Zawsze wybieraj uczciwość.",
                key_2_title: "Praca zespołowa", key_2_desc: "Priorytet dla grupy.",
                key_3_title: "Empatia", key_3_desc: "Bierz pod uwagę uczucia innych.",
                key_4_title: "Elastyczność", key_4_desc: "Radzenie sobie ze stresem.",
                ex_title: "Analiza Scenariusza", ex_desc: "Oceń odpowiedzi od najlepszej do najgorszej.",
                sc_title: "SCENARIUSZ:", sc_text: "Pracujesz w grupie. Alex nie pracuje. Termin jutro.",
                best_lbl: "✅ Najlepsze:", best_txt: "Porozmawiaj z Alexem prywatnie.",
                avg_lbl: "⚠️ Średnie:", avg_txt: "Podziel pracę Alexa.",
                worst_lbl: "❌ Najgorsze:", worst_txt: "Zgłoś Alexa natychmiast.",
                quiz_title: "Test Próbny",
                q1: "1. Widzisz ściąganie. Co robisz?", q1_a: "A) Ignoruję.", q1_b: "B) Zgłaszam dyskretnie.", q1_c: "C) Konfrontuję.",
                q2: "2. Dwa terminy na raz. Co robisz?", q2_a: "A) Robię byle jak.", q2_b: "B) Jeden spóźniam.", q2_c: "C) Proszę o przedłużenie.",
                q3: "3. Klient jest zły nie z Twojej winy.", q3_a: "A) Rozwiązuję problem.", q3_b: "B) Kłócę się.", q3_c: "C) Ignoruję.",
                cta_text: "Więcej scenariuszy?", cta_btn: "Skontaktuj się",
                form_header: "Pomoc w nauce?", form_sub: "Skontaktuj się z nami.",
                lbl_name: "Imię i Nazwisko", lbl_phone: "Telefon", lbl_email: "Email", lbl_msg: "Pytania", btn_send: "Wyślij"
            },
            hu: {
                nav_courses: "Tanfolyamok", nav_team: "Tanácsadók", nav_reviews: "Vélemények", nav_contact: "Kapcsolat", nav_back: "Vissza",
                hero_title: "Helyzetmegítélési Tesztek", hero_desc: "A döntéshozatal művészete.",
                intro_title: "Mik a Pszichometriai Tesztek?", intro_text: "Készségeket mérnek. Nincs rossz válasz, csak hatékony.",
                key_1_title: "Integritás", key_1_desc: "Légy őszinte.",
                key_2_title: "Csapatmunka", key_2_desc: "A csoport sikere fontos.",
                key_3_title: "Empátia", key_3_desc: "Mások érzései.",
                key_4_title: "Rugalmasság", key_4_desc: "Stresszkezelés.",
                ex_title: "Elemzés", ex_desc: "Rangsorolja a válaszokat.",
                sc_title: "SZITUÁCIÓ:", sc_text: "Csoportmunka. Alex nem dolgozik. Határidő holnap.",
                best_lbl: "✅ Legjobb:", best_txt: "Beszélj Alexszel privátban.",
                avg_lbl: "⚠️ Átlagos:", avg_txt: "Alex munkájának elosztása.",
                worst_lbl: "❌ Legrosszabb:", worst_txt: "Alex jelentése azonnal.",
                quiz_title: "Gyakorló Teszt",
                q1: "1. Csalást látsz. Mit teszel?", q1_a: "A) Semmit.", q1_b: "B) Jelzem diszkréten.", q1_c: "C) Kiabálok.",
                q2: "2. Két határidő. Mit teszel?", q2_a: "A) Sietek.", q2_b: "B) Késve adom le.", q2_c: "C) Hosszabbítást kérek.",
                q3: "3. Dühös ügyfél. Mit teszel?", q3_a: "A) Megoldom.", q3_b: "B) Vitatkozom.", q3_c: "C) Ignorálom.",
                cta_text: "Több gyakorlás?", cta_btn: "Kapcsolat",
                form_header: "Segítség?", form_sub: "Lépjen kapcsolatba velünk.",
                lbl_name: "Teljes Név", lbl_phone: "Telefon", lbl_email: "Email", lbl_msg: "Kérdések", btn_send: "Küldés"
            },
            es: {
                nav_courses: "Cursos", nav_team: "Asesores", nav_reviews: "Reseñas", nav_contact: "Contacto", nav_back: "Volver",
                hero_title: "Juicio Situacional", hero_desc: "Domina la toma de decisiones.",
                intro_title: "¿Qué son Pruebas Psicométricas?", intro_text: "Evalúan habilidades blandas. No hay respuestas 'incorrectas', solo ineficaces.",
                key_1_title: "Integridad", key_1_desc: "Elige la honestidad.",
                key_2_title: "Trabajo en equipo", key_2_desc: "Prioriza el grupo.",
                key_3_title: "Empatía", key_3_desc: "Considera a los demás.",
                key_4_title: "Adaptabilidad", key_4_desc: "Manejo del estrés.",
                ex_title: "Análisis", ex_desc: "Clasifica de Más a Menos Efectivo.",
                sc_title: "ESCENARIO:", sc_text: "Trabajo en grupo. Alex no ayuda. Fecha límite mañana.",
                best_lbl: "✅ Mejor:", best_txt: "Hablar con Alex en privado.",
                avg_lbl: "⚠️ Promedio:", avg_txt: "Hacer su trabajo.",
                worst_lbl: "❌ Peor:", worst_txt: "Reportar a Alex ya.",
                quiz_title: "Prueba Práctica",
                q1: "1. Ves a alguien haciendo trampa.", q1_a: "A) Ignorar.", q1_b: "B) Informar discretamente.", q1_c: "C) Confrontar.",
                q2: "2. Dos fechas límite.", q2_a: "A) Apurarse.", q2_b: "B) Entregar tarde.", q2_c: "C) Pedir extensión.",
                q3: "3. Cliente enojado.", q3_a: "A) Resolver.", q3_b: "B) Discutir.", q3_c: "C) Ignorar.",
                cta_text: "¿Más escenarios?", cta_btn: "Contactar Asesor",
                form_header: "¿Ayuda?", form_sub: "Contáctanos para coaching.",
                lbl_name: "Nombre Completo", lbl_phone: "Teléfono", lbl_email: "Email", lbl_msg: "Preguntas", btn_send: "Enviar"
            },
            it: {
                nav_courses: "Corsi", nav_team: "Advisor", nav_reviews: "Recensioni", nav_contact: "Contatti", nav_back: "Indietro",
                hero_title: "Test di Giudizio Situazionale", hero_desc: "Padroneggia le decisioni.",
                intro_title: "Cosa sono i Test Psicometrici?", intro_text: "Valutano le soft skills. Cerca la risposta più efficace.",
                key_1_title: "Integrità", key_1_desc: "Scegli l'onestà.",
                key_2_title: "Teamwork", key_2_desc: "Il gruppo prima di tutto.",
                key_3_title: "Empatia", key_3_desc: "Considera gli altri.",
                key_4_title: "Adattabilità", key_4_desc: "Gestione stress.",
                ex_title: "Analisi", ex_desc: "Classifica le risposte.",
                sc_title: "SCENARIO:", sc_text: "Lavoro di gruppo. Alex non lavora. Scadenza domani.",
                best_lbl: "✅ Migliore:", best_txt: "Parla con Alex in privato.",
                avg_lbl: "⚠️ Media:", avg_txt: "Fai il suo lavoro.",
                worst_lbl: "❌ Peggiore:", worst_txt: "Segnala Alex subito.",
                quiz_title: "Test Pratico",
                q1: "1. Uno studente copia.", q1_a: "A) Ignori.", q1_b: "B) Informi discretamente.", q1_c: "C) Confronti.",
                q2: "2. Due scadenze.", q2_a: "A) Corri.", q2_b: "B) Ritardo.", q2_c: "C) Chiedi proroga.",
                q3: "3. Cliente arrabbiato.", q3_a: "A) Risolvi.", q3_b: "B) Litighi.", q3_c: "C) Ignori.",
                cta_text: "Più scenari?", cta_btn: "Contatta Advisor",
                form_header: "Aiuto?", form_sub: "Contattaci.",
                lbl_name: "Nome Completo", lbl_phone: "Telefono", lbl_email: "Email", lbl_msg: "Domande", btn_send: "Invia"
            },
            pt: {
                nav_courses: "Cursos", nav_team: "Consultores", nav_reviews: "Avaliações", nav_contact: "Contato", nav_back: "Voltar",
                hero_title: "Testes de Julgamento Situacional", hero_desc: "Domine a tomada de decisão.",
                intro_title: "O que são Testes Psicométricos?", intro_text: "Avaliam soft skills. Busque a resposta mais eficaz.",
                key_1_title: "Integridade", key_1_desc: "Escolha a honestidade.",
                key_2_title: "Trabalho em equipe", key_2_desc: "Priorize o grupo.",
                key_3_title: "Empatia", key_3_desc: "Considere os outros.",
                key_4_title: "Adaptabilidade", key_4_desc: "Lidar com estresse.",
                ex_title: "Análise", ex_desc: "Classifique as respostas.",
                sc_title: "CENÁRIO:", sc_text: "Trabalho em grupo. Alex não ajuda. Prazo amanhã.",
                best_lbl: "✅ Melhor:", best_txt: "Fale com Alex em privado.",
                avg_lbl: "⚠️ Média:", avg_txt: "Faça o trabalho dele.",
                worst_lbl: "❌ Pior:", worst_txt: "Denuncie Alex já.",
                quiz_title: "Teste Prático",
                q1: "1. Vê alguém colando.", q1_a: "A) Ignora.", q1_b: "B) Informa discretamente.", q1_c: "C) Confronta.",
                q2: "2. Dois prazos.", q2_a: "A) Corre.", q2_b: "B) Entrega tarde.", q2_c: "C) Pede extensão.",
                q3: "3. Cliente irritado.", q3_a: "A) Resolve.", q3_b: "B) Discute.", q3_c: "C) Ignora.",
                cta_text: "Mais cenários?", cta_btn: "Contatar",
                form_header: "Ajuda?", form_sub: "Contacte-nos.",
                lbl_name: "Nome Completo", lbl_phone: "Telefone", lbl_email: "Email", lbl_msg: "Perguntas", btn_send: "Enviar"
            },
            el: {
                nav_courses: "Μαθήματα", nav_team: "Σύμβουλοι", nav_reviews: "Κριτικές", nav_contact: "Επαφή", nav_back: "Πίσω",
                hero_title: "Τεστ Κατάστασης", hero_desc: "Λήψη αποφάσεων.",
                intro_title: "Τι είναι τα Ψυχομετρικά;", intro_text: "Αξιολογούν δεξιότητες. Βρείτε την αποτελεσματική λύση.",
                key_1_title: "Ακεραιότητα", key_1_desc: "Ειλικρίνεια.",
                key_2_title: "Ομαδικότητα", key_2_desc: "Επιτυχία ομάδας.",
                key_3_title: "Ενσυναίσθηση", key_3_desc: "Σκέψου τους άλλους.",
                key_4_title: "Προσαρμοστικότητα", key_4_desc: "Διαχείριση άγχους.",
                ex_title: "Ανάλυση", ex_desc: "Κατατάξτε τις απαντήσεις.",
                sc_title: "ΣΕΝΑΡΙΟ:", sc_text: "Ομαδική εργασία. Ο Alex δεν βοηθά. Προθεσμία αύριο.",
                best_lbl: "✅ Καλύτερη:", best_txt: "Μίλα στον Alex ιδιαιτέρως.",
                avg_lbl: "⚠️ Μέτρια:", avg_txt: "Κάνε τη δουλειά του.",
                worst_lbl: "❌ Χειρότερη:", worst_txt: "Ανάφερέ τον αμέσως.",
                quiz_title: "Τεστ",
                q1: "1. Αντιγραφή σε εξετάσεις.", q1_a: "A) Αγνοείς.", q1_b: "B) Ενημερώνεις διακριτικά.", q1_c: "C) Τσακώνεσαι.",
                q2: "2. Δύο προθεσμίες.", q2_a: "A) Βιάζεσαι.", q2_b: "B) Αργείς.", q2_c: "C) Ζητάς παράταση.",
                q3: "3. Θυμωμένος πελάτης.", q3_a: "A) Το λύνεις.", q3_b: "B) Μα ώνεις.", q3_c: "C) Αγνοείς.",
                cta_text: "Περισσότερα;", cta_btn: "Επικοινωνία",
                form_header: "Βοήθεια;", form_sub: "Επικοινωνήστε μαζί μας.",
                lbl_name: "Ονοματεπώνυμο", lbl_phone: "Τηλέφωνο", lbl_email: "Email", lbl_msg: "Ερωτήσεις", btn_send: "Αποστολή"
            },
            bg: {
                nav_courses: "Курсове", nav_team: "Съветници", nav_reviews: "Отзиви", nav_contact: "Контакт", nav_back: "Назад",
                hero_title: "Ситуационни Тестове", hero_desc: "Вземане на решения.",
                intro_title: "Какво са психометричните тестове?", intro_text: "Оценяват умения. Търсете ефективния отговор.",
                key_1_title: "Честност", key_1_desc: "Бъдете честни.",
                key_2_title: "Екипност", key_2_desc: "Успехът на групата.",
                key_3_title: "Емпатия", key_3_desc: "Мислете за другите.",
                key_4_title: "Адаптивност", key_4_desc: "Справяне със стрес.",
                ex_title: "Анализ", ex_desc: "Класирайте отговорите.",
                sc_title: "СЦЕНАРИЙ:", sc_text: "Групов проект. Алекс не помага. Срокът е утре.",
                best_lbl: "✅ Най-добро:", best_txt: "Говорете с Алекс насаме.",
                avg_lbl: "⚠️ Средно:", avg_txt: "Свършете работата му.",
                worst_lbl: "❌ Най-лошо:", worst_txt: "Докладвайте го веднага.",
                quiz_title: "Тест",
                q1: "1. Преписване на изпит.", q1_a: "A) Игнорирам.", q1_b: "B) Съобщавам дискретно.", q1_c: "C) Конфронтирам.",
                q2: "2. Два крайни срока.", q2_a: "A) Бързам.", q2_b: "B) Закъснявам.", q2_c: "C) Искам удължаване.",
                q3: "3. Ядосан клиент.", q3_a: "A) Решавам проблема.", q3_b: "B) Споря.", q3_c: "C) Игнорирам.",
                cta_text: "Още сценарии?", cta_btn: "Контакт",
                form_header: "Помощ?", form_sub: "Свържете се с нас.",
                lbl_name: "Име", lbl_phone: "Телефон", lbl_email: "Имейл", lbl_msg: "Въпроси", btn_send: "Изпрати"
            }
        };

        function toggleLangMenu() {
            document.getElementById('lang-dropdown').classList.toggle('active');
        }

        function setLang(lang) {
            const langNames = { en:"English", ro:"Română", pl:"Polski", hu:"Magyar", es:"Español", it:"Italiano", pt:"Português", el:"Ελληνικά", bg:"Български" };
            document.getElementById('current-lang').innerText = langNames[lang];
            document.getElementById('lang-dropdown').classList.remove('active');
            
            const t = translations[lang] || translations['en'];
            document.querySelectorAll('[data-key]').forEach(el => {
                const key = el.getAttribute('data-key');
                if(t[key]) el.textContent = t[key];
            });
        }

        // Quiz Logic
        let score = 0;
        let answeredCount = 0;
        const totalQuestions = 3;

        function checkAnswer(element, isCorrect) {
            if (element.parentElement.classList.contains('answered')) return;
            element.parentElement.classList.add('answered');
            answeredCount++;

            if (isCorrect) {
                element.classList.add('correct');
                element.innerHTML += ' <i class="fa-solid fa-check-circle" style="margin-left:auto;"></i>';
                score++;
            } else {
                element.classList.add('wrong');
                element.innerHTML += ' <i class="fa-solid fa-times-circle" style="margin-left:auto;"></i>';
                const siblings = element.parentElement.children;
                for (let i = 0; i < siblings.length; i++) {
                    if (siblings[i].getAttribute('onclick').includes('true')) {
                        siblings[i].classList.add('correct');
                        siblings[i].innerHTML += ' <i class="fa-solid fa-check-circle" style="margin-left:auto;"></i>';
                    }
                }
            }

            if (answeredCount === totalQuestions) {
                const scoreBoard = document.getElementById('score-board');
                scoreBoard.style.display = 'block';
                scoreBoard.innerHTML = `You scored ${score} / ${totalQuestions}`;
            }
        }

        window.onclick = function(event) {
            if (!event.target.matches('.lang-btn') && !event.target.closest('.lang-btn')) {
                var dropdowns = document.getElementsByClassName("lang-dropdown");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('active')) {
                        openDropdown.classList.remove('active');
                    }
                }
            }
        }
    </script>

</body>
</html>
