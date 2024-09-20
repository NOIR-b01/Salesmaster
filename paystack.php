
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="conatiner">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Pay with Paystack
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Pay with Paystack</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="paymentForm">
                            <div class="form-group">
                                <label class="mt-1" for="email">Email Address</label>
                                <input class="form-control" type="email" id="email-address" required />
                            </div>
                            <div class="form-group">
                                <label class="mt-2" for="amount">Amount</label>
                                <input class="form-control" type="tel" id="amount" required />
                            </div>
                            <div class="form-group">
                                <label class="mt-2" for="first-name">First Name</label>
                                <input class="form-control" type="text" id="first-name" />
                            </div>
                            <div class="form-group">
                                <label class="mt-2" for="last-name">Last Name</label>
                                <input class="form-control" type="text" id="last-name" />
                            </div>
                            <div class="form-submit">
                            <button type="Submit" class="btn btn-primary mt-2" onclick="payWithPaystack()">Pay</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>

    <script>
        const paymentForm = document.getElementById('paymentForm');
        paymentForm.addEventListener("submit", payWithPaystack, false);

        function payWithPaystack(e) {
            e.preventDefault();

            let handler = PaystackPop.setup({
                key: 'pk_test_795d779e21245d2bb3c349d193ee41572af57971', // Replace with your public key
                email: document.getElementById("email-address").value,
                amount: document.getElementById("amount").value * 100,
                // currency: NGN,
                ref: '' + Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
                // label: "Optional string that replaces customer email"
                onClose: function() {
                    alert('Window closed.');
                },
                callback: function(response) {
                    let message = 'Payment complete! Reference: ' + response.reference;
                    alert(message);
                }
            });

            handler.openIframe();
        }
    </script>
</body>

</html>