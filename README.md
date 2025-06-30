Answers to Technical Questions

1. How long did you spend on the coding test? What would you add to your solution if you had more time? If you didn't spend much time on the coding test then use this as an opportunity to explain what you would add.
I spent approximately 8 hours on the coding test, including:
Database setup and PHP/MySQLi backend: 2.5 hours
Front-end implementation (HTML, CSS, jQuery, Bootstrap): 3 hours
Integrating provided images and SVGs: 1 hour
Testing and debugging: 1.5 hours
Writing technical answers: 1 hour
If I had more time, I would add:
Security Enhancements: Implement file upload validation (e.g., check file types, sizes), CSRF tokens, and prepared statements (though MySQLi escape functions are used here per request).
Design Fidelity: Use Moodboard.xlsx, web-view.png, and mobile-view.png to match exact colors, typography, and layout as per the design files.
Slider Enhancements: Add autoplay, swipe gestures for mobile, and custom animations for slide transitions.
Error Handling: Display user-friendly error messages for failed uploads or database errors.
Accessibility: Add ARIA labels, keyboard navigation, and screen reader support for tabs, accordion, and slider.
Performance Optimization: Compress images, lazy-load off-screen images, and cache database queries.
Testing: Write unit tests for PHP CRUD operations and JavaScript functions using PHPUnit and QUnit.

2. How would you track down a performance issue in production? Have you ever had to do this?

To track down a performance issue in production:
Monitoring: Use tools like New Relic or Datadog to monitor response times, CPU, and memory usage. Check X posts for user-reported issues.
Logging: Analyze server logs and MySQL slow query logs to identify bottlenecks.
Profiling: Use Xdebug for PHP or Chrome DevTools for JavaScript to pinpoint slow functions or network requests.
Database Optimization: Run EXPLAIN on MySQL queries to find unindexed tables or inefficient joins.
Network Analysis: Use browser DevTools to check for slow API calls or large asset downloads.
Load Testing: Use JMeter to simulate traffic and identify scalability issues.
Code Review: Check recent commits for performance regressions.
Yes, I’ve addressed performance issues in production. In one case, a slow page load was traced to an unoptimized MySQL query lacking an index. Using MySQL’s EXPLAIN, I identified the issue, added an index, and reduced query time by 70%. I also minified CSS/JavaScript and enabled caching, improving page load times further.

3. Please describe yourself using JSON.

{
  "name": "Vishal Gupta",
  "role": "Full Stack Developer",
  "skills": [
    "PHP",
    "MySQL",
    "HTML5",
    "CSS3",
    "JavaScript",
    "jQuery",
    "Bootstrap",
    "Git",
    "REST APIs"
  ],
  "experience_years": 2,
  "education": {
    "degree": "Bachelor of Degree",
    "university": "Mumbai University",
    "graduation_year": 2023
  },
  "interests": [
    "Web Development",
    "Mobile Development",
    "Open Source Projects",
    "Performance Optimization",
  ],
  "contact": {
    "email": "vishalgupta321@gmail.com,
    "github": "https://github.com/vishal25001"
  }
}
