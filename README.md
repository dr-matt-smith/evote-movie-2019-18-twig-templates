# evote-movie-2019-19-twig-templates

Part of the progressive Movie Voting website project at: https://github.com/dr-matt-smith/evote-movie-2019


The project has been refactored as follows:

- Twig library added to project

    ```bash
        composer require twig/twig
    ```

- create new class `Controller`, this adds a `$this->twig` variable to all sub-classes:

    ```php
          namespace TuDublin;
          
          use Twig\Loader\FilesystemLoader;
          use Twig\Environment;
          
          class Controller
          {
              protected $twig;
          
              public function __construct()
              {
                  // my settings
                  // ------------
                  $myTemplatesPath = __DIR__ . '/../templates';
          
                  // setup twig
                  // ------------
                  $loader = new FilesystemLoader($myTemplatesPath);
                  $this->twig = new Environment($loader);
          
                  $this->twig->addGlobal('session', $_SESSION);
              }
          }
    ```

- refactor **all** controller classes to extend our new `Controller` class, e.g.:

    ```php
          namespace TuDublin;
          
          class MainController extends Controller
          {        
              ... as before
    ```
    
- create a new Twig template `base.html.twig`, that combines the `_header` and `_footer`, and also creates blocks for:

    - pageTitle
    - navigation styles
    - body (to be overridden by page main content)
    
    - also:
    
        - set login session variables for `isLoggedIn` and `username`

    - here is the content for `/templates/base.html.twig`:
    
    
    ```twig
        {# ----------- SESSION bits - isLoggedIn and username ------- #}
        {% set username = session.username %}
        
        {% if username is null %}
            {% set isLoggedIn = false %}
        {% else %}
            {% set isLoggedIn = true %}
        {% endif %}
        {# ----------- SESSION bits - isLoggedIn and username ------- #}
        
        <!doctype html>
        <html lang="en">
        <head>
            <title>EVOTE MOVIE - {% block pageTitle %}{% endblock %} page</title>
            <meta charset="utf-8">
            <style>
                @import "/css/basic.css";
                @import "/css/nav.css";
                @import "/css/footer.css";
            </style>
        </head>
        <body>
        
        
        
        <header>
            <!-- LOGIN LINK -->
            <span style="float: right; text-align: right;">
                {% if isLoggedIn %}
                You are logged in as: <strong>{{ username }}</strong>
                    <br>
                    <a href="index.php?action=logout">Logout</a>
                {% else %}
                <a href="index.php?action=login">Login</a>
                {% endif %}
            </span>
        
            <!-- LOGO -->
            <img src="/images/smithit_logo.gif" alt="logo">
        </header>
        
        
        <nav>
            <ul>
                <li>
                    <a href="index.php" class="{% block homePageStyle %}{% endblock %}">Home</a>
                </li>
        
                <li>
                    <a href="index.php?action=about"  class="{% block aboutPageStyle %}{% endblock %}">About Us</a>
                </li>
        
                <li>
                    <a href="index.php?action=list"  class="{% block listPageStyle %}{% endblock %}">Movie ratings</a>
                </li>
        
                <li>
                    <a href="index.php?action=listCheap"  class="{% block listCheapPageStyle %}{% endblock %}">cheap movies</a>
                </li>
        
                <li>
                    <a href="index.php?action=contact"  class="{% block contactPageStyle %}{% endblock %}">Contact Us</a>
                </li>
        
                <li>
                    <a href="index.php?action=sitemap"  class="<{% block sitemapPageStyle %}{% endblock %}">Site Map</a>
                </li>
        
                <li>
                    <a href="index.php?action=charts"  class="{% block chartPageStyle %}{% endblock %}">Charts</a>
                </li>
            </ul>
        </nav>
        
        {% block body %}
        {% endblock %}
        
        
        <footer>
            2019 &copy; A Matt Smith productions international enterprises limited production
        </footer>
        
        </body>
        </html>
    ```
    
- now create a new homepage template `/templates/index.html.twig`:

    ```twig
      {% extends 'base.html.twig' %}
      
      {% block pageTitle %}home{% endblock %}
      
      {% block homePageStyle %}current_page{% endblock %}
      
      {% block body %}
      <h1>
      Welcome to SmithIT Home Page
      </h1>
      
      <p>
      This site offers you the chance to VOTE on your favourite movies ...
      </p>
      
      {% endblock %}
    ```
    
- now edit the `MainController` action:

    ```php
          public function home()
          {
              $template = 'index.html.twig';
              $args = [];
      
              $html = $this->twig->render($template, $args);
              print $html;
          }
    ```
    

You now need to edit all controllers to use Twig, and create Twig versions of each template ...