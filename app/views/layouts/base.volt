<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <!-- <title>{{ title ? title|e|striptags : 'Untitled' }}</title> -->
        <title>{% block title %}{% endblock %} - My Webpage</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <?php $this->assets->outputCss(); ?>
    </head>
    <body>
        <div class="hold-transition skin-blue sidebar-mini">
            <div class="wrapper">
                {% block header %}
                    
                {% endblock %}
                {% block sidebar %}
                    
                {% endblock %}
                {% block content %}{% endblock %}
            </div>
        </div>
        <?php $this->assets->outputJs(); ?>
        {% block javascript %}
        {% endblock %}
    </body>
</html>
