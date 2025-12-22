document.addEventListener("DOMContentLoaded", function () {
    const fileInput = document.getElementById("formFile");
    const previewImg = document.getElementById("profile-img");

    if (fileInput && previewImg) {
        fileInput.addEventListener("change", function () {
            const file = fileInput.files[0];
            if (file) {
                previewImg.src = URL.createObjectURL(file);
            }
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const fileInputs = document.querySelectorAll(
        'input[type="file"][data-preview-target]'
    );

    fileInputs.forEach(function (input) {
        input.addEventListener("change", function (e) {
            const previewId = e.target.getAttribute("data-preview-target");
            const previewImg = document.getElementById(previewId);

            if (e.target.files && e.target.files[0] && previewImg) {
                previewImg.src = URL.createObjectURL(e.target.files[0]);
            }
        });
    });
});
