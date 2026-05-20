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
    <title>Interview Prep | Case Studies</title>
    
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

        /* NAV - Standardized */
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
        
        .steps-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-top: 30px; }
        .step-item { padding: 25px; border-radius: 6px; background: #fff; border: 1px solid var(--border-color); position: relative; overflow: hidden; }
        .step-num { font-size: 3rem; font-weight: 700; color: rgba(180, 83, 9, 0.15); position: absolute; top: -10px; right: 10px; font-family: 'Playfair Display', serif; }
        .step-item h3 { margin-bottom: 10px; position: relative; z-index: 2; color: var(--primary); font-weight: 700; }
        .step-item p { font-size: 0.9rem; color: var(--text-muted); position: relative; z-index: 2; }

        .case-box { border: 1px solid var(--border-color); border-radius: 8px; overflow: hidden; }
        .case-header { background: #f8fafc; padding: 20px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; cursor: pointer; transition: 0.3s; font-weight: bold; color: var(--text-main); }
        .case-header:hover { background: #f1f5f9; color: var(--primary); }
        .case-content { padding: 25px; display: none; background: white; }
        .case-content.active { display: block; animation: slideDown 0.4s ease; }
        .solution-box { margin-top: 20px; padding: 20px; background: #f0fdf4; border-left: 4px solid #22c55e; border-radius: 4px; display: none; }

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
            <h1 data-key="hero_title">Mastering Case Studies</h1>
            <p data-key="hero_desc">Learn how to analyze complex academic and business scenarios to demonstrate your critical thinking skills.</p>
        </div>
    </header>

    <main class="container fade-in" style="animation-delay: 0.2s;">
        
        <div class="card" style="margin-top: -40px;">
            <h2 data-key="intro_title" style="color:var(--primary); font-weight:700; margin-bottom:15px;">What is a Case Study Interview?</h2>
            <p style="color:var(--text-muted); margin-bottom: 20px;" data-key="intro_text">Interviews for Business, Law, and Health courses often include a case study. You will be given a hypothetical problem and asked to propose a solution. The interviewer is not looking for the "correct" answer, but rather <strong>how you think</strong>.</p>
            
            <h3 data-key="steps_title" style="margin-top: 30px; font-weight:700; color:var(--secondary);">The 4-Step Framework</h3>
            <div class="steps-grid">
                <div class="step-item">
                    <span class="step-num">01</span>
                    <h3 data-key="step_1_t">Identify</h3>
                    <p data-key="step_1_d">Clarify the core problem. What is the main issue causing the trouble?</p>
                </div>
                <div class="step-item">
                    <span class="step-num">02</span>
                    <h3 data-key="step_2_t">Analyze</h3>
                    <p data-key="step_2_d">Break it down. Who is involved? What are the constraints (time, money)?</p>
                </div>
                <div class="step-item">
                    <span class="step-num">03</span>
                    <h3 data-key="step_3_t">Solve</h3>
                    <p data-key="step_3_d">Propose 2-3 solutions. Weigh the pros and cons of each.</p>
                </div>
                <div class="step-item">
                    <span class="step-num">04</span>
                    <h3 data-key="step_4_t">Conclude</h3>
                    <p data-key="step_4_d">Pick the best solution and explain why it is superior.</p>
                </div>
            </div>
        </div>

        <div class="card">
            <h2 data-key="tool_title" style="color:var(--primary); font-weight:700; margin-bottom:15px;">Analytical Tools</h2>
            <p style="margin-bottom:20px;" data-key="tool_desc">Use these frameworks to structure your thoughts quickly.</p>
            
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                <div style="background:#f8fafc; padding:20px; border-radius:6px; border-left:4px solid var(--primary);">
                    <h3 style="color:var(--primary); font-weight:700;">SWOT Analysis</h3>
                    <ul style="font-size:0.9rem; color:var(--text-muted); margin-top:10px; margin-left:20px;">
                        <li data-key="swot_s"><strong>Strengths:</strong> What is going well?</li>
                        <li data-key="swot_w"><strong>Weaknesses:</strong> What is lacking?</li>
                        <li data-key="swot_o"><strong>Opportunities:</strong> What can be improved?</li>
                        <li data-key="swot_t"><strong>Threats:</strong> What are the risks?</li>
                    </ul>
                </div>
                <div style="background:#fffcf0; padding:20px; border-radius:6px; border-left:4px solid var(--secondary);">
                    <h3 style="color:var(--secondary); font-weight:700;">Pros vs. Cons</h3>
                    <p style="font-size:0.9rem; margin-top:10px;" data-key="pros_desc">Simple but effective. List the benefits and drawbacks of a specific action before recommending it.</p>
                </div>
            </div>
        </div>

        <div class="card">
            <h2 style="text-align: center; margin-bottom: 30px; color:var(--primary); font-weight:700;"><i class="fa-solid fa-briefcase"></i> <span data-key="case_title">Interactive Practice Case</span></h2>
            
            <div class="case-box">
                <div class="case-header" onclick="toggleCase('case1')">
                    <strong data-key="c1_head">Case 1: The Struggling Business</strong>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>
                <div id="case1" class="case-content">
                    <p><strong data-key="scen_lbl">Scenario:</strong> <span data-key="c1_text">A local coffee shop has seen a 20% drop in customers since a large chain opened across the street. They cannot compete on price. What should they do?</span></p>
                    
                    <button class="btn btn-outline" style="margin-top:15px; font-size:0.8rem;" onclick="showSolution('sol1')" data-key="btn_reveal">Reveal Solution</button>
                    
                    <div id="sol1" class="solution-box">
                        <strong data-key="sol_lbl">Model Answer (Using SWOT):</strong>
                        <p style="font-size:0.9rem; margin-top:5px;" data-key="c1_sol">
                            1. <strong>Identify:</strong> The problem is competition from a big chain with lower prices.<br>
                            2. <strong>Analyze:</strong> We cannot win a price war. We must find a different competitive advantage (Quality/Service).<br>
                            3. <strong>Solution:</strong> Focus on what the chain cannot do: personalized community events, higher quality artisanal beans, and a cozy atmosphere.<br>
                            4. <strong>Conclusion:</strong> Rebrand as a premium community hub rather than a fast-coffee stop.
                        </p>
                    </div>
                </div>
            </div>
            <br>
            <div class="case-box">
                <div class="case-header" onclick="toggleCase('case2')">
                    <strong data-key="c2_head">Case 2: The Academic Dilemma</strong>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>
                <div id="case2" class="case-content">
                    <p><strong data-key="scen_lbl">Scenario:</strong> <span data-key="c2_text">You are leading a group project. Two members are arguing constantly, delaying progress. The deadline is in 3 days. What do you do?</span></p>
                    <button class="btn btn-outline" style="margin-top:15px; font-size:0.8rem;" onclick="showSolution('sol2')" data-key="btn_reveal">Reveal Solution</button>
                    <div id="sol2" class="solution-box">
                        <strong data-key="sol_lbl">Model Answer:</strong>
                        <p style="font-size:0.9rem; margin-top:5px;" data-key="c2_sol">
                            1. <strong>Identify:</strong> Conflict is blocking productivity. Deadline risk is high.<br>
                            2. <strong>Immediate Action:</strong> Call a meeting. Acknowledge the conflict neutrally.<br>
                            3. <strong>Compromise:</strong> Divide the remaining tasks so the arguing members do not have to collaborate directly on the same section.<br>
                            4. <strong>Conclusion:</strong> Prioritize submission. Address the interpersonal issues fully after the deadline is met.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" id="contact" style="background: var(--primary); color: white; border: none;">
            <h2 class="section-header" style="color: white; border-bottom: 2px solid rgba(255,255,255,0.2); justify-content: center;"><i class="fa-solid fa-envelope"></i> <span data-key="form_header">Need help with Prep?</span></h2>
            <p style="margin-bottom: 30px; text-align: center; opacity: 0.9;" data-key="form_sub">Contact us for personalized interview coaching.</p>
            
            <form action="https://api.web3forms.com/submit" method="POST">
                
                <input type="hidden" name="access_key" value="<?php echo $web3FormsKey; ?>">
                
                <input type="checkbox" name="botcheck" class="hidden" style="display: none;">

                <input type="hidden" name="subject" value="New Prep Inquiry (Case Studies)">
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
        function toggleCase(id) {
            const el = document.getElementById(id);
            if (el.classList.contains('active')) {
                el.style.display = "none";
                el.classList.remove('active');
            } else {
                el.style.display = "block";
                el.classList.add('active');
            }
        }

        function showSolution(id) {
            document.getElementById(id).style.display = "block";
        }

        function toggleMobileMenu() {
            document.getElementById('mobile-menu').classList.toggle('active');
        }

        function toggleLangMenu() {
            document.getElementById('lang-dropdown').classList.toggle('active');
        }

     const translations = {
    en: {
        nav_courses: "Courses", nav_team: "Advisors", nav_reviews: "Reviews", nav_contact: "Contact Us",
        hero_title: "Mastering Case Studies", 
        hero_desc: "Learn how to analyze complex academic and business scenarios to demonstrate your critical thinking skills.",
        intro_title: "What is a Case Study Interview?", 
        intro_text: "Interviews for Business, Law, and Health courses often include a case study. You will be given a hypothetical problem and asked to propose a solution. The interviewer is not looking for the 'correct' answer, but rather HOW you think.",
        steps_title: "The 4-Step Framework", 
        step_1_t: "Identify", step_1_d: "Clarify the core problem. What is the main issue causing the trouble?",
        step_2_t: "Analyze", step_2_d: "Break it down. Who is involved? What are the constraints (time, money)?",
        step_3_t: "Solve", step_3_d: "Propose 2-3 solutions. Weigh the pros and cons of each.",
        step_4_t: "Conclude", step_4_d: "Pick the best solution and explain why it is superior.",
        tool_title: "Analytical Tools", 
        tool_desc: "Use these frameworks to structure your thoughts quickly.",
        swot_s: "Strengths: What goes well?", swot_w: "Weaknesses: What is lacking?", swot_o: "Opportunities: What to improve?", swot_t: "Threats: What are risks?",
        pros_desc: "List the benefits and drawbacks of a specific action before recommending it.",
        case_title: "Interactive Practice Case", 
        scen_lbl: "Scenario:", 
        btn_reveal: "Reveal Solution", 
        sol_lbl: "Model Answer:",
        c1_head: "Case 1: The Struggling Business", 
        c1_text: "A local coffee shop has seen a 20% drop in customers since a large chain opened across the street. They cannot compete on price. What should they do?", 
        c1_sol: "1. Identify: Competition on price failed. 2. Analyze: Must find other value. 3. Solution: Focus on what the chain cannot do (Quality/Community). 4. Conclusion: Rebrand as premium.",
        c2_head: "Case 2: The Academic Dilemma", 
        c2_text: "You are leading a group project. Two members are arguing constantly, delaying progress. The deadline is in 3 days. What do you do?",
        c2_sol: "1. Identify: Conflict blocks productivity. 2. Action: Call a meeting, acknowledge conflict neutrally. 3. Compromise: Divide tasks to minimize direct contact. 4. Conclusion: Prioritize submission.",
        form_header: "Need help with Prep?", form_sub: "Contact us for personalized interview coaching.",
        lbl_name: "Full Name", lbl_phone: "Phone Number", lbl_email: "Email Address", lbl_msg: "Questions / Goals", btn_send: "Send Request"
    },

    ro: {
        nav_courses: "Cursuri", nav_team: "Consilieri", nav_reviews: "Recenzii", nav_contact: "Contact",
        hero_title: "Stăpânirea Studiilor de Caz", 
        hero_desc: "Învață să analizezi scenarii complexe academice și de afaceri pentru a demonstra gândirea critică.",
        intro_title: "Ce este un Interviu tip Studiu de Caz?", 
        intro_text: "Interviurile pentru cursurile de Afaceri, Drept și Sănătate includ adesea un studiu de caz. Ți se va da o problemă ipotetică. Ei vor să vadă CUM gândești.",
        steps_title: "Cadrul în 4 Pași", 
        step_1_t: "Identifică", step_1_d: "Clarifică problema de bază.",
        step_2_t: "Analizează", step_2_d: "Descompune problema. Cine e implicat?",
        step_3_t: "Rezolvă", step_3_d: "Propune 2-3 soluții. Cântărește avantajele.",
        step_4_t: "Concluzionează", step_4_d: "Alege cea mai bună soluție.",
        tool_title: "Instrumente Analitice", 
        tool_desc: "Folosește aceste cadre pentru a structura gândirea.",
        swot_s: "Puncte Tari: Ce merge bine?", swot_w: "Puncte Slabe: Ce lipsește?", swot_o: "Oportunități: Ce se poate îmbunătăți?", swot_t: "Amenințări: Care sunt riscurile?",
        pros_desc: "Listează beneficiile și dezavantajele înainte de a recomanda o acțiune.",
        case_title: "Practică Interactivă", 
        scen_lbl: "Scenariu:", 
        btn_reveal: "Arată Soluția", 
        sol_lbl: "Răspuns Model:",
        c1_head: "Cazul 1: Afacerea în Dificultate", 
        c1_text: "O cafenea a pierdut 20% din clienți din cauza unui lanț mare. Nu pot concura la preț. Ce fac?", 
        c1_sol: "1. Identifică: Competiția la preț a eșuat. 2. Analiză: Trebuie găsită altă valoare. 3. Soluție: Focus pe calitate/comunitate. 4. Concluzie: Rebranding premium.",
        c2_head: "Cazul 2: Dilema Academică", 
        c2_text: "Membrii echipei se ceartă constant. Termenul limită e în 3 zile. Ce faci?",
        c2_sol: "1. Identifică: Conflictul blochează progresul. 2. Acțiune: Separă sarcinile pentru a minimiza contactul. 3. Concluzie: Prioritizează predarea.",
        form_header: "Ai nevoie de ajutor?", form_sub: "Contactează-ne pentru pregătire personalizată.",
        lbl_name: "Nume Complet", lbl_phone: "Telefon", lbl_email: "Email", lbl_msg: "Întrebări / Scopuri", btn_send: "Trimite Cerere"
    },
    
    pl: {
        nav_courses: "Kursy", nav_team: "Doradcy", nav_reviews: "Opinie", nav_contact: "Kontakt",
        hero_title: "Studia Przypadku", 
        hero_desc: "Naucz się analizować złożone scenariusze.",
        intro_title: "Co to jest Case Study?", 
        intro_text: "Otrzymasz hipotetyczny problem. Rekruterzy chcą zobaczyć JAK myślisz.",
        steps_title: "4 Kroki", 
        step_1_t: "Zidentyfikuj", step_1_d: "Określ główny problem.",
        step_2_t: "Analizuj", step_2_d: "Rozbij na części. Ograniczenia?",
        step_3_t: "Rozwiąż", step_3_d: "Zaproponuj rozwiązania.",
        step_4_t: "Wnioskuj", step_4_d: "Wybierz najlepsze.",
        tool_title: "Narzędzia", 
        tool_desc: "Użyj tych ram do strukturyzacji myśli.",
        swot_s: "Mocne strony", swot_w: "Słabe strony", swot_o: "Szanse", swot_t: "Zagrożenia",
        pros_desc: "Wymień zalety i wady przed podjęciem decyzji.",
        case_title: "Praktyka Interaktywna", 
        scen_lbl: "Scenariusz:", 
        btn_reveal: "Pokaż Rozwiązanie", 
        sol_lbl: "Wzorowa Odpowiedź:",
        c1_head: "Przypadek 1: Biznes", 
        c1_text: "Kawiarnia traci klientów na rzecz sieciówki. Nie mogą konkurować ceną. Co robić?",
        c1_sol: "1. Zidentyfikuj: Walka cenowa przegrana. 2. Analizuj: Znajdź inną wartość. 3. Rozwiązanie: Jakość/Społeczność. 4. Wniosek: Marka premium.",
        c2_head: "Przypadek 2: Studia", 
        c2_text: "Kłótnia w grupie projektowej. Termin za 3 dni. Co robisz?",
        c2_sol: "1. Zidentyfikuj: Konflikt blokuje postęp. 2. Działanie: Podziel zadania. 3. Wniosek: Priorytetem jest oddanie pracy.",
        form_header: "Pomoc w nauce?", form_sub: "Skontaktuj się z nami.",
        lbl_name: "Imię i Nazwisko", lbl_phone: "Telefon", lbl_email: "Email", lbl_msg: "Pytania", btn_send: "Wyślij"
    },

    hu: {
        nav_courses: "Tanfolyamok", nav_team: "Tanácsadók", nav_reviews: "Vélemények", nav_contact: "Kapcsolat",
        hero_title: "Esettanulmányok Mesterfokon", 
        hero_desc: "Tanuld meg elemezni a komplex forgatókönyveket.",
        intro_title: "Mi az az Esettanulmány Interjú?", 
        intro_text: "Kapsz egy hipotetikus problémát. Azt nézik, HOGYAN gondolkodsz.",
        steps_title: "A 4 Lépéses Keret", 
        step_1_t: "Azonosítás", step_1_d: "Tisztázd a fő problémát.",
        step_2_t: "Elemzés", step_2_d: "Bontsd részletekre.",
        step_3_t: "Megoldás", step_3_d: "Javasolj megoldásokat.",
        step_4_t: "Következtetés", step_4_d: "Válaszd a legjobbat.",
        tool_title: "Elemzési Eszközök", 
        tool_desc: "Használd ezeket a gondolataid rendezéséhez.",
        swot_s: "Erősségek", swot_w: "Gyengeségek", swot_o: "Lehetőségek", swot_t: "Veszélyek",
        pros_desc: "Sorold fel az előnyöket és hátrányokat.",
        case_title: "Interaktív Gyakorlat", 
        scen_lbl: "Szituáció:", 
        btn_reveal: "Megoldás Megjelenítése", 
        sol_lbl: "Minta Válasz:",
        c1_head: "1. Eset: A Küzdő Üzlet", 
        c1_text: "Egy kávézó elvesztette ügyfelei 20%-át. Árban nem versenyezhetnek. Mit tegyenek?",
        c1_sol: "1. Azonosítás: Az árverseny sikertelen. 2. Elemzés: Más értéket kell találni. 3. Megoldás: Minőség/Közösség. 4. Következtetés: Prémium márka.",
        c2_head: "2. Eset: Akadémiai Dilemma", 
        c2_text: "Csoportos vita. Határidő 3 nap múlva. Mit teszel?",
        c2_sol: "1. Azonosítás: A konfliktus gátolja a haladást. 2. Cselekvés: Feladatok szétválasztása. 3. Következtetés: A leadás a prioritás.",
        form_header: "Segítség?", form_sub: "Lépjen kapcsolatba velünk.",
        lbl_name: "Teljes Név", lbl_phone: "Telefon", lbl_email: "Email", lbl_msg: "Kérdések", btn_send: "Küldés"
    },

    es: {
        nav_courses: "Cursos", nav_team: "Asesores", nav_reviews: "Reseñas", nav_contact: "Contacto",
        hero_title: "Dominando los Casos de Estudio", 
        hero_desc: "Aprende a analizar escenarios complejos.",
        intro_title: "¿Qué es una Entrevista de Caso?", 
        intro_text: "Se te dará un problema hipotético. Quieren ver CÓMO piensas.",
        steps_title: "El Marco de 4 Pasos", 
        step_1_t: "Identificar", step_1_d: "Aclarar el problema central.",
        step_2_t: "Analizar", step_2_d: "Desglosarlo. ¿Restricciones?",
        step_3_t: "Resolver", step_3_d: "Proponer soluciones.",
        step_4_t: "Concluir", step_4_d: "Elegir la mejor solución.",
        tool_title: "Herramientas Analíticas", 
        tool_desc: "Usa estos marcos para estructurar tus pensamientos.",
        swot_s: "Fortalezas", swot_w: "Debilidades", swot_o: "Oportunidades", swot_t: "Amenazas",
        pros_desc: "Enumera los pros y contras.",
        case_title: "Práctica Interactiva", 
        scen_lbl: "Escenario:", 
        btn_reveal: "Ver Solución", 
        sol_lbl: "Respuesta Modelo:",
        c1_head: "Caso 1: El Negocio en Problemas", 
        c1_text: "Una cafetería pierde clientes. No pueden competir en precio. ¿Qué hacer?", 
        c1_sol: "1. Identificar: Precio fallido. 2. Analizar: Buscar otro valor. 3. Solución: Calidad/Comunidad. 4. Conclusión: Marca premium.",
        c2_head: "Caso 2: El Dilema Académico", 
        c2_text: "Discusión en grupo. Plazo en 3 días. ¿Qué haces?",
        c2_sol: "1. Identificar: El conflicto bloquea. 2. Acción: Dividir tareas. 3. Conclusión: Priorizar la entrega.",
        form_header: "¿Ayuda?", form_sub: "Contáctanos para coaching.",
        lbl_name: "Nombre Completo", lbl_phone: "Teléfono", lbl_email: "Email", lbl_msg: "Preguntas", btn_send: "Enviar"
    },

    it: {
        nav_courses: "Corsi", nav_team: "Advisor", nav_reviews: "Recensioni", nav_contact: "Contatti",
        hero_title: "Padroneggiare i Casi Studio", 
        hero_desc: "Impara ad analizzare scenari complessi.",
        intro_title: "Cos'è un Caso Studio?", 
        intro_text: "Ti verrà dato un problema ipotetico. Vogliono vedere COME pensi.",
        steps_title: "Il Metodo in 4 Passi", 
        step_1_t: "Identifica", step_1_d: "Chiarisci il problema.",
        step_2_t: "Analizza", step_2_d: "Scomponilo.",
        step_3_t: "Risolvi", step_3_d: "Proponi soluzioni.",
        step_4_t: "Concludi", step_4_d: "Scegli la migliore.",
        tool_title: "Strumenti Analitici", 
        tool_desc: "Struttura i tuoi pensieri.",
        swot_s: "Punti di forza", swot_w: "Debolezze", swot_o: "Opportunità", swot_t: "Minacce",
        pros_desc: "Elenca pro e contro.",
        case_title: "Pratica Interattiva", 
        scen_lbl: "Scenario:", 
        btn_reveal: "Vedi Soluzione", 
        sol_lbl: "Risposta Modello:",
        c1_head: "Caso 1: Business in Crisi", 
        c1_text: "Una caffetteria perde clienti. Non può competere sul prezzo. Cosa fare?", 
        c1_sol: "1. Identifica: Prezzo fallito. 2. Analizza: Trova altro valore. 3. Soluzione: Qualità/Comunità. 4. Conclusione: Brand premium.",
        c2_head: "Caso 2: Dilemma Accademico", 
        c2_text: "Lite nel gruppo. Scadenza in 3 giorni. Cosa fai?",
        c2_sol: "1. Identifica: Il conflitto blocca. 2. Azione: Dividi i compiti. 3. Conclusione: Priorità alla consegna.",
        form_header: "Aiuto?", form_sub: "Contattaci.",
        lbl_name: "Nome Completo", lbl_phone: "Telefono", lbl_email: "Email", lbl_msg: "Domande", btn_send: "Invia"
    },

    pt: {
        nav_courses: "Cursos", nav_team: "Consultores", nav_reviews: "Avaliações", nav_contact: "Contato",
        hero_title: "Dominando Estudos de Caso", 
        hero_desc: "Aprenda a analisar cenários complexos.",
        intro_title: "O que é um Estudo de Caso?", 
        intro_text: "Será dado um problema hipotético. Eles querem ver COMO você pensa.",
        steps_title: "A Estrutura de 4 Passos", 
        step_1_t: "Identificar", step_1_d: "Clarificar o problema.",
        step_2_t: "Analisar", step_2_d: "Decompor.",
        step_3_t: "Resolver", step_3_d: "Propor soluções.",
        step_4_t: "Concluir", step_4_d: "Escolher a melhor.",
        tool_title: "Ferramentas Analíticas", 
        tool_desc: "Estruture seus pensamentos.",
        swot_s: "Forças", swot_w: "Fraquezas", swot_o: "Oportunidades", swot_t: "Ameaças",
        pros_desc: "Liste prós e contras.",
        case_title: "Prática Interativa", 
        scen_lbl: "Cenário:", 
        btn_reveal: "Ver Solução", 
        sol_lbl: "Resposta Modelo:",
        c1_head: "Caso 1: Negócio em Luta", 
        c1_text: "Café perdendo clientes. Não pode competir no preço. O que fazer?", 
        c1_sol: "1. Identificar: Preço falhou. 2. Analisar: Buscar outro valor. 3. Solução: Qualidade/Comunidade. 4. Conclusão: Marca premium.",
        c2_head: "Caso 2: Dilema Acadêmico", 
        c2_text: "Conflito no grupo. Prazo em 3 dias. O que faz?",
        c2_sol: "1. Identificar: Conflito bloqueia. 2. Ação: Dividir tarefas. 3. Conclusão: Priorizar entrega.",
        form_header: "Ajuda?", form_sub: "Contacte-nos.",
        lbl_name: "Nome Completo", lbl_phone: "Telefone", lbl_email: "Email", lbl_msg: "Perguntas", btn_send: "Enviar"
    },

    el: {
        nav_courses: "Μαθήματα", nav_team: "Σύμβουλοι", nav_reviews: "Κριτικές", nav_contact: "Επαφή",
        hero_title: "Κυριαρχώντας στις Μελέτες Περίπτωσης", 
        hero_desc: "Μάθετε να αναλύετε πολύπλοκα σενάρια.",
        intro_title: "Τι είναι η Συνέντευξη Μελέτης Περίπτωσης;", 
        intro_text: "Θα σας δοθεί ένα υποθετικό πρόβλημα. Θέλουν να δουν ΠΩΣ σκέφτεστε.",
        steps_title: "Το Πλαίσιο 4 Βημάτων", 
        step_1_t: "Αναγνώριση", step_1_d: "Διευκρινίστε το πρόβλημα.",
        step_2_t: "Ανάλυση", step_2_d: "Αναλύστε το.",
        step_3_t: "Λύση", step_3_d: "Προτείνετε λύσεις.",
        step_4_t: "Συμπέρασμα", step_4_d: "Επιλέξτε την καλύτερη.",
        tool_title: "Αναλυτικά Εργαλεία", 
        tool_desc: "Οργανώστε τη σκέψη σας.",
        swot_s: "Δυνάμεις", swot_w: "Αδυναμίες", swot_o: "Ευκαιρίες", swot_t: "Απειλές",
        pros_desc: "Λίστα υπέρ και κατά.",
        case_title: "Διαδραστική Πρακτική", 
        scen_lbl: "Σενάριο:", 
        btn_reveal: "Εμφάνιση Λύσης", 
        sol_lbl: "Πρότυπη Απάντηση:",
        c1_head: "Υπόθεση 1: Η Επιχείρηση", 
        c1_text: "Μια καφετέρια χάνει πελάτες. Δεν μπορεί να ανταγωνιστεί στην τιμή. Τι να κάνει;", 
        c1_sol: "1. Αναγνώριση: Η τιμή απέτυχε. 2. Ανάλυση: Βρείτε άλλη αξία. 3. Λύση: Ποιότητα/Κοινότητα. 4. Συμπέρασμα: Premium μάρκα.",
        c2_head: "Υπόθεση 2: Ακαδημαϊκό Δίλημμα", 
        c2_text: "Διαφωνία ομάδας. Προθεσμία σε 3 μέρες. Τι κάνετε;",
        c2_sol: "1. Αναγνώριση: Η σύγκρουση εμποδίζει. 2. Δράση: Διαχωρισμός εργασιών. 3. Συμπέρασμα: Προτεραιότητα η παράδοση.",
        form_header: "Βοήθεια;", form_sub: "Επικοινωνήστε μαζί μας.",
        lbl_name: "Ονοματεπώνυμο", lbl_phone: "Τηλέφωνο", lbl_email: "Email", lbl_msg: "Ερωτήσεις", btn_send: "Αποστολή"
    },

    bg: {
        nav_courses: "Курсове", nav_team: "Съветници", nav_reviews: "Отзиви", nav_contact: "Контакт",
        hero_title: "Овладяване на Казуси", 
        hero_desc: "Научете се да анализирате сложни сценарии.",
        intro_title: "Какво е интервю по казус?", 
        intro_text: "Ще ви бъде даден хипотетичен проблем. Те искат да видят КАК мислите.",
        steps_title: "Рамката от 4 стъпки", 
        step_1_t: "Идентифицирай", step_1_d: "Изяснете проблема.",
        step_2_t: "Анализирай", step_2_d: "Разбийте го.",
        step_3_t: "Реши", step_3_d: "Предложете решения.",
        step_4_t: "Заключи", step_4_d: "Изберете най-доброто.",
        tool_title: "Аналитични Инструменти", 
        tool_desc: "Структурирайте мислите си.",
        swot_s: "Силни страни", swot_w: "Слаби страни", swot_o: "Възможности", swot_t: "Заплахи",
        pros_desc: "Списък с плюсове и минуси.",
        case_title: "Интерактивна Практика", 
        scen_lbl: "Сценарий:", 
        btn_reveal: "Виж Решение", 
        sol_lbl: "Примерен Отговор:",
        c1_head: "Казус 1: Затруднен Бизнес", 
        c1_text: "Кафене губи клиенти. Не може да се конкурира с цената. Какво да прави?", 
        c1_sol: "1. Идентифицирай: Цената не работи. 2. Анализирай: Намери друга стойност. 3. Решение: Качество/Общност. 4. Заключение: Премиум марка.",
        c2_head: "Казус 2: Академична Дилема", 
        c2_text: "Конфликт в групата. Срок 3 дни. Какво правите?",
        c2_sol: "1. Идентифицирай: Конфликтът блокира. 2. Действие: Разделете задачите. 3. Заключение: Приоритет е предаването.",
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
                if(t[key]) el.innerHTML = t[key];
            });
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
