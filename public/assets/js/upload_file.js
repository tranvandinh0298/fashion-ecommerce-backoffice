// Get the CSRF token value from the meta tag in your HTML layout
var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// DropzoneJS Demo Code Start
Dropzone.autoDiscover = false

// Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
var previewNode = document.querySelector("#template")
previewNode.id = ""
var previewTemplate = previewNode.parentNode.innerHTML
previewNode.parentNode.removeChild(previewNode)

let storeUrl = document.getElementById("store-url").value;

var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
    url: storeUrl, // Set the url
    headers: {
        'X-CSRF-TOKEN': csrfToken // Include the CSRF token in the headers
    },
    maxFilesize: 5, // Maximum file size in MB
    acceptedFiles: ".jpg,.png,.gif", // Allowed file types
    thumbnailWidth: 80,
    thumbnailHeight: 80,
    parallelUploads: 20,
    previewTemplate: previewTemplate,
    autoQueue: false, // Make sure the files aren't queued until manually added
    previewsContainer: "#previews", // Define the container to display the previews
    clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
})

myDropzone.on("addedfile", function (file) {
    // Hookup the start button
    file.previewElement.querySelector(".start").onclick = function () {
        myDropzone.enqueueFile(file)
    }
})

// Update the total progress bar
myDropzone.on("totaluploadprogress", function (progress) {
    document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
})

myDropzone.on("sending", function (file) {
    // Show the total progress bar when upload starts
    document.querySelector("#total-progress").style.opacity = "1"
    // And disable the start button
    file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
})

// Hide the total progress bar when nothing's uploading anymore
myDropzone.on("queuecomplete", function (progress) {
    document.querySelector("#total-progress").style.opacity = "0"
})

// Listen for success event
myDropzone.on("success", function (file, response) {
    console.log("File uploaded successfully:", "upload thành công");
});

// Setup the buttons for all transfers
// The "add files" button doesn't need to be setup because the config
// `clickable` has already been specified.
document.querySelector("#actions .start").onclick = function () {
    myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
}
document.querySelector("#actions .cancel").onclick = function () {
    myDropzone.removeAllFiles(true)
}
// DropzoneJS Demo Code End



// // Initialize Dropzone
// Dropzone.autoDiscover = false;
// var myDropzone = new Dropzone("#myDropzone", {
//     url: "/images/store",
//     headers: {
//         'X-CSRF-TOKEN': csrfToken // Include the CSRF token in the headers
//     },
//     maxFilesize: 5, // Maximum file size in MB
//     acceptedFiles: ".jpg,.png,.gif", // Allowed file types
//     addRemoveLinks: true // Add remove links for uploaded files
// });

// // Listen for success event
// myDropzone.on("success", function (file, response) {
//     console.log("File uploaded successfully:", response);
// });

// // Listen for error event
// myDropzone.on("error", function (file, errorMessage) {
//     console.error("Error uploading file:", errorMessage);
// });

// // Manually trigger file upload
// document.querySelector("#uploadButton").addEventListener("click", function () {
//     myDropzone.processQueue(); // Upload all files in the queue
// });