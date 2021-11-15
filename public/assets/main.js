


const { PDFDocument, StandardFonts, rgb, degrees } = PDFLib


async function embedImages(url, sign) {

    // Fetch JPEG image
    //const jpgUrl = 'https://pdf-lib.js.org/assets/cat_riding_unicorn.jpg'
    const jpgUrl = 'upload/signature.jpg'
    const jpgImageBytes = await fetch(jpgUrl).then((res) => res.arrayBuffer())

    const jpgUrls = 'upload/stamp.jpg'
    const jpgImageBytess = await fetch(jpgUrls).then((res) => res.arrayBuffer())

    // Fetch PNG image
    const pngUrl = 'https://pdf-lib.js.org/assets/minions_banana_alpha.png'
    const pngImageBytes = await fetch(pngUrl).then((res) => res.arrayBuffer())

    // Create a new PDFDocument
    const existingPdfBytes = await fetch(url).then(res => res.arrayBuffer())

    // Load a PDFDocument from the existing PDF bytes
    const pdfDoc = await PDFDocument.load(existingPdfBytes)

    // Embed the JPG image bytes and PNG image bytes
    const jpgImage = await pdfDoc.embedJpg(jpgImageBytes)
    const jpgImages = await pdfDoc.embedJpg(jpgImageBytess)
    const pngImage = await pdfDoc.embedPng(pngImageBytes)

    const pages = pdfDoc.getPages()
    const firstPage = pages[0]

    // Get the width/height of the JPG image scaled down to 25% of its original size
    const jpgDims = jpgImage.scale(0.05)
    const jpgDimss = jpgImages.scale(0.05)

    // Get the width/height of the PNG image scaled down to 50% of its original size
    const pngDims = pngImage.scale(0.5)

    // Add a blank page to the document
    //const page = pdfDoc.addPage()

    // Draw the JPG image in the center of the page
    // firstPage.drawImage(jpgImage, {
    //     x: firstPage.getWidth() / 2 - jpgDims.width / 2,
    //     y: firstPage.getHeight() / 2 - jpgDims.height / 2,
    //     width: jpgDims.width,
    //     height: jpgDims.height,
    // })

    firstPage.drawImage(jpgImage, {
        x: firstPage.getWidth() / 10,
        y: firstPage.getHeight() /10 + 80,
        width: jpgDims.width,
        height: jpgDims.height,
    })

    firstPage.drawImage(jpgImages, {
        x: firstPage.getWidth() - 150,
        y: firstPage.getHeight() /10 + 80,
        width: jpgDimss.width,
        height: jpgDimss.height,
    })

    // Draw the PNG image near the lower right corner of the JPG image
    // firstPage.drawImage(pngImage, {
    //     x: firstPage.getWidth() / 2 - pngDims.width / 2 + 75,
    //     y: firstPage.getHeight() / 2 - pngDims.height,
    //     width: pngDims.width,
    //     height: pngDims.height,
    // })

    // Serialize the PDFDocument to bytes (a Uint8Array)
    const pdfBytes = await pdfDoc.save()

    // Trigger the browser to download the PDF document
    download(pdfBytes, url, "application/pdf");
}




async function modifyPdf(url) {
    //const url = 'https://pdf-lib.js.org/assets/with_update_sections.pdf'
    const existingPdfBytes = await fetch(url).then(res => res.arrayBuffer())

    // Load a PDFDocument from the existing PDF bytes
    const pdfDoc = await PDFDocument.load(existingPdfBytes)

    // Embed the Helvetica font
    const helveticaFont = await pdfDoc.embedFont(StandardFonts.Helvetica)

    // Get the first page of the document
    const pages = pdfDoc.getPages()
    const firstPage = pages[0]

    // Get the width and height of the first page
    const { width, height } = firstPage.getSize()

    // Draw a string of text diagonally across the first page
    firstPage.drawText('This text was added with JavaScript!', {
        x: 5,
        y: height / 2 + 300,
        size: 50,
        font: helveticaFont,
        color: rgb(0.95, 0.1, 0.1),
        rotate: degrees(-45),
    })

    // Serialize the PDFDocument to bytes (a Uint8Array)
    const pdfBytes = await pdfDoc.save()

    // Trigger the browser to download the PDF document
    download(pdfBytes, url, "application/pdf");
}
