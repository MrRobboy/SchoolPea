$(document).ready(function() {
    // Toggle chatbox visibility
    $("#chat-circle").click(function() {
      $(".chat-box").toggle('scale');
    });
    
    $(".chat-box-toggle").click(function() {
      $(".chat-box").toggle('scale');
    });
  
    // Handle form submission
    $("#chatForm").submit(function(event) {
      event.preventDefault();
      const message = $("#chat-input").val().trim();
      
      if (message) {
        const messageElement = `<div class="chat-msg user">${message}</div>`;
        $(".chat-logs").append(messageElement);
        $("#chat-input").val('');
        $(".chat-logs").scrollTop($(".chat-logs")[0].scrollHeight);
      }
    });
  
    // Send button functionality
    $("#sendButton").click(function() {
      const message = $("#textAreaExample2").val().trim();
  
      if (message) {
        const messageElement = `
        <li class="d-flex justify-content-between mb-4">
          <div class="card w-100">
            <div class="card-header d-flex justify-content-between p-3">
              <p class="fw-bold mb-0">You</p>
              <p class="text-muted small mb-0"><i class="far fa-clock"></i> Just now</p>
            </div>
            <div class="card-body">
              <p class="mb-0">${message}</p>
            </div>
          </div>
        </li>`;
        $(".list-unstyled").append(messageElement);
        $("#textAreaExample2").val('');
        $("html, body").animate({ scrollTop: $(document).height() }, 1000);
      }
    });
  });
  