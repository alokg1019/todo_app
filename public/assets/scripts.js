$("body").on("click","#checkAll_pending_list",function()
{
    $(".pending_tasks").prop('checked',true);
});


$("body").on("click","#pending_task_save",function(){

    var checkboxes = $(".pending_tasks");
    var taskList = [];
    checkboxes.each(function(){

        var id = $(this).attr('id');
        if($(this).prop('checked'))
        {
            taskList.push(id);
        }

    })

    var error_div = $("#pending_list_error");
    var success_div = $("#pending_list_success");

    if(taskList.length == 0)
    {
        error_div.empty().append("Please select atleast 1 task.").show();
        success_div.hide();
        return false;
    }

    error_div.hide();
    success_div.hide();

    $.post("ajax/complete_task.php", {
        task: taskList,
    }, function (result) {

        result = JSON.parse(result);
        if(result.status == "success")
        {
            error_div.hide();
            success_div.empty().append(result.message).show();
            location.reload();
        }
        else
        {
            success_div.hide();
            error_div.empty().append(result.message).show();
        }

    });

});