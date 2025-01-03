export function pdfPreview() {
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('license-upload').addEventListener('change', function (event) {
            const file = event.target.files[0];

            if (file && file.type === "application/pdf") {
                // Create a URL for the uploaded file
                const fileURL = URL.createObjectURL(file);

                // Display the PDF preview
                const previewContainer = document.getElementById('pdf-preview-container');
                const previewFrame = document.getElementById('pdf-preview');
                previewFrame.src = fileURL;
                previewContainer.classList.remove('hidden');
            } else {
                alert("Please upload a valid PDF file.");
            }
        });
    });
}
