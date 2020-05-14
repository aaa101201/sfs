var job_id;
$(function () {
  // 绑定工作详情页
  $(document).on("pageInit", "#bizJobDetail", function(e, id, page) {

      var path = location.pathname;
      var jobId  = path.slice(path.lastIndexOf('/')+1);
      job_id = jobId;
      function loadDetail(jobId){

          $.ajax({
              type: 'POST',
              url:APP_PATH+ '/Company/Job/getJobDetails',
              data: {"id": jobId},
              dataType: 'json',
              timeout: 3000,
              context: $('#jobDetailScroll'),

              success: function(res){
                  if(res.code=='0'){
                      $.toast("(+﹏+) 找不到这个职位了", 1000, "toast_orange");
                      return;
                  } else {
                      var job= res.data;
                      console.log("job", job);

                      //电话咨询时“元/月”不显示
                      var num = /^[0-9,\.,\-,\+,\~]*$/;
                      var income = job.income;
                      var bool = num.test(income);
                      if(!bool){
                        job.incomeunit = '';
                      }
                      var html = template("job-detail-tpl", job);
                      this.html(html);   
                  }
          },
          error: function(xhr, type){
            console.log(xhr);
            console.log(type);
            $.toast("(+﹏+) 萝卜们太热情，服务器表示鸭梨很大！", 1000, "toast_orange");
          }
        });
      }

      loadDetail(jobId);
  });
});