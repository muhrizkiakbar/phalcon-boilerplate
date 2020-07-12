
{% if action == 'new' %}
    {{ form('/cars', 'method': 'post') }}
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Add A Car</h3>
        </div>
{% else %}
    <form id="form-edit">
{%endif%}

        {% if action == 'new' %}
            <div class="box-body">
        {% endif %}

                <div class="form-group">
                    <label for="brand">Brand</label>
                    {{ text_field('brand', 'class': "form-control") }}
                </div>
                <div class="form-group">
                    <label for="type">Type</label>
                    {{ text_field('type', 'class': "form-control") }}
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    {{ text_field('name', 'class': "form-control") }}
                </div>
                <div class="form-group">
                    <label for="wheels">Wheels</label>
                    {{ numeric_field('wheels', 'class': "form-control") }}
                </div>
        {% if action == 'new' %}
            </div>
        {% endif %}
        <!-- /.box-body -->
        {% if action == 'new' %}
        <div class="box-footer">
            {{ submit_button('Submit','class':"btn btn-primary") }}

        </div>
        {% else %}
            {{ submit_button('Submit','class':"btn btn-primary") }}
        {% endif %}

{{ endForm() }}

{% if action == 'new' %}
    </div>
{% else%}
    </form>
{% endif %}

