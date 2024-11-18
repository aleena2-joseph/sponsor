document.addEventListener('DOMContentLoaded', () => {
    // DOM elements
    const connectMetaMask = document.getElementById('connectMetaMask');
    const donateButton = document.getElementById('donateButton');
    const donationPopup = document.getElementById('donationPopup');
    const closePopup = document.getElementById('closePopup');
    const receiverForm = document.getElementById('receiverForm');
    const verificationStatus = document.getElementById('verificationStatus');
    const viewStatusButton = document.getElementById('viewStatus');
    const withdrawButton = document.getElementById('withdrawButton');
    const requestStatus = document.getElementById('requestStatus');
    let userAddress;

    // Connect to MetaMask
    if (connectMetaMask) {
        connectMetaMask.addEventListener('click', async () => {
            if (typeof window.ethereum !== 'undefined') {
                try {
                    const accounts = await window.ethereum.request({ method: 'eth_requestAccounts' });
                    userAddress = accounts[0];
                    alert(`Connected to MetaMask: ${userAddress}`);
                } catch (error) {
                    console.error('MetaMask connection error:', error);
                    alert('Failed to connect to MetaMask.');
                }
            } else {
                alert('MetaMask is not installed. Please install MetaMask to continue.');
            }
        });
    }

    // Handle donation button click
    if (donateButton) {
        donateButton.addEventListener('click', () => {
            const receiverAddress = document.getElementById('receiverAddress').value;
            const donationAmount = document.getElementById('donationAmount').value;

            if (receiverAddress && donationAmount) {
                donationPopup.classList.remove('hidden');
            } else {
                alert('Please fill in both the receiver address and donation amount.');
            }
        });
    }

    // Close donation popup
    if (closePopup) {
        closePopup.addEventListener('click', () => {
            donationPopup.classList.add('hidden');
        });
    }

    // Handle receiver form submission
    if (receiverForm) {
        receiverForm.addEventListener('submit', (event) => {
            event.preventDefault();
            const idProofType = document.getElementById('idProofType').value;
            const idProofFile = document.getElementById('idProofFile').files[0];

            if (idProofType && idProofFile) {
                // Show verification status
                verificationStatus.classList.remove('hidden');
                alert('ID proof submitted successfully for verification.');
            } else {
                alert('Please select a valid ID proof type and upload the corresponding file.');
            }
        });
    }

    // Handle view status button click
    if (viewStatusButton) {
        viewStatusButton.addEventListener('click', () => {
            const currentStatus = requestStatus.textContent || "No status available.";
            alert(`Current Request Status: ${currentStatus}`);
        });
    }

    // Handle withdraw request
    if (withdrawButton) {
        withdrawButton.addEventListener('click', () => {
            requestStatus.textContent = "Approved";
            alert("Withdrawal approved. Amount transferred successfully!");
        });
    }
});
