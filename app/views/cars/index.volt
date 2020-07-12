{% extends 'cars/cars.volt' %}


{% block content %}
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    {{super()}}
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-8">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Cars Table</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <th>Brand</th>
                  <th>Type</th>
                  <th>Name</th>
                  <th>Wheels</th>
                  <th>Tools</th>
                </tr>
                {% for car in page.items %}
                  <tr id="row{{car.id}}">
                    <td>{{car.brand}}</td>
                    <td>{{car.type}}</td>
                    <td>{{car.name}}</td>
                    <td>{{car.wheels}}</td>
                    <td>
                      <button type="button" 
                        class="btn btn-sm btn-info button-modal" 
                        data-toggle="modal" 
                        data-id="{{car.id}}" 
                        data-brand="{{car.brand}}"
                        data-name="{{car.name}}"
                        data-type="{{car.type}}"
                        data-wheels="{{car.wheels}}"
                        data-target=".modal-edit">
                        Edit Car
                      </button>
                      <button type="button" 
                        class="btn btn-sm btn-danger button-modal-delete" 
                        data-toggle="modal" 
                        data-id="{{car.id}}" 
                        data-brand="{{car.brand}}"
                        data-name="{{car.name}}"
                        data-type="{{car.type}}"
                        data-wheels="{{car.wheels}}"
                        data-target=".modal-delete">
                        Delete Car
                      </button>
                    </td>
                  </tr>
                {% endfor  %}
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <ul class="pagination pagination-sm no-margin pull-right">
                <li><?php echo $this->tag->linkTo( [ "/cars", "First", 'class' => 'page-link' ] ) ?></li>
                <li><?php echo $this->tag->linkTo( [
                        "/cars/?page=" . $page->before,
                        "Previous",
                        'class' => 'page-link'
                      ] ) ?>
                </li>
                <li><?php echo $this->tag->linkTo( [
                        "/cars/?page=" . $page->next,
                        "Next",
                        'class' => 'page-link'
                      ] ) ?>
                </li>
                <li><?php echo $this->tag->linkTo( [
                        "/cars/?page=" . $page->last,
                        "Last",
                        'class' => 'page-link'
                      ] ) ?>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <!-- general form elements -->
          {{ partial('cars/form', ['action': 'new']) }}
          <?php echo ($this->getContent()) ?>
          
          <!-- /.box -->


        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>
  {{ partial("cars/modal") }}
  
{% endblock %}

{% block javascript %}
    <script>
        let id
        let brand
        let type
        let name
        let wheels

        let request;

      $(document).on('click','.button-modal', function(){
        console.log("edit")
        id = undefined
        brand = undefined
        type = undefined
        name = undefined
        wheels = undefined
        id = $(this).attr('data-id')
        brand = $(this).attr('data-brand')
        type = $(this).attr('data-type')
        name = $(this).attr('data-name')
        wheels = $(this).attr('data-wheels')

        $('#form-edit #brand').val(brand)
        $('#form-edit #type').val(type)
        $('#form-edit #name').val(name)
        $('#form-edit #wheels').val(wheels)

        $('#modal-default .modal-footer').html(''); 
      });

      $(document).on('submit',"#form-edit",function(event){
        event.preventDefault();


        if (request) {
            request.abort();
        }

        let $form = $(this);


        var $inputs = $form.find("input, select, button, textarea");


        var serializedData = $form.serialize();

        $inputs.prop("disabled", true);


        request = $.ajax({
            dataType: 'json',
            url: "/cars/"+id,
            type: "put",
            data: serializedData
        });

        request.done(function (response, textStatus, jqXHR){
          $('#row'+id).removeData();
          $('#row'+id).html('')
            $('#row'+id).html('\
              <td>'+response[0]["brand"]+'</td>\
              <td>'+response[0]["type"]+'</td>\
              <td>'+response[0]["name"]+'</td>\
              <td>'+response[0]["wheels"]+'</td>\
              <td>\
                <button type="button" \
                  class="btn btn-sm btn-info button-modal" \
                  data-toggle="modal" \
                  data-id="'+id+'" \
                  data-brand="'+response[0]["brand"]+'"\
                  data-name="'+response[0]["name"]+'"\
                  data-type="'+response[0]["type"]+'"\
                  data-wheels="'+response[0]["wheels"]+'"\
                  data-target=".modal-edit">\
                  Edit Car</button>\
                <button type="button" \
                      class="btn btn-sm btn-danger button-modal-delete" \
                      data-toggle="modal" \
                      data-id="'+id+'" \
                      data-brand="'+response[0]["brand"]+'"\
                      data-name="'+response[0]["name"]+'"\
                      data-type="'+response[0]["type"]+'"\
                      data-wheels="'+response[0]["wheels"]+'"\
                      data-target=".modal-delete">\
                      Delete Car\
                    </button>\
              </td>\
            ');

            $('#modal-default .modal-footer').html(''); 
            $('#modal-default').modal('toggle');
        });


        request.fail(function (response,jqXHR, textStatus, errorThrown){
          $('#modal-default .modal-footer').html(''); 
            var i;
            for (i = 0; i < response.responseJSON["error"].length; i++) {
              $('#modal-default .modal-footer').append('<div class="alert alert-danger text-left">'+response.responseJSON["error"][i]+'</div>')
              console.log(i)
            }

            
        });

        request.always(function () {
            $inputs.prop("disabled", false);
        });
        console.log($form)
      })


      $(document).on('click','.button-modal-delete', function(){

        console.log("delete")
        id = $(this).attr('data-id')
        brand = $(this).attr('data-brand')
        type = $(this).attr('data-type')
        name = $(this).attr('data-name')
        wheels = $(this).attr('data-wheels')

        $('#modal-delete .modal-body').html('\
          <p>Are you sure to delete Brand '+brand+', type of '+type+', name of '+name+'and wheels '+wheels+' ? </p>\
        ')
      });

      $(document).on('click','#deletecar',function(){

        request = $.ajax({
            dataType: 'json',
            url: "/cars/"+id,
            type: "delete",
        });

        request.done(function (response, textStatus, jqXHR){
          $('#row'+id).removeData();
          $('#row'+id).remove()
          $('#modal-delete').modal('toggle');
        });


        request.fail(function (response,jqXHR, textStatus, errorThrown){
          $('#modal-default .modal-footer').html(''); 
            var i;
            for (i = 0; i < response.responseJSON["error"].length; i++) {
              $('#modal-default .modal-footer').append('<div class="alert alert-danger text-left">'+response.responseJSON["error"][i]+'</div>')
              console.log(i)
            }

            
        });
      })

    </script>
{% endblock %}