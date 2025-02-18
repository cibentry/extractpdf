from flask import Flask, request, jsonify
import pdfplumber
import re

app = Flask(__name__)

def extract_policy_details(pdf_path):
    with pdfplumber.open(pdf_path) as pdf:
        text = "\n".join([page.extract_text() for page in pdf.pages if page.extract_text()])

    data = {
        "Name": re.search(r"Name\s*([\w\s]+)", text, re.IGNORECASE),
        "Policy No": re.search(r"Policy No\.?\s*[:]?([\d\/\s]+)", text, re.IGNORECASE),
        "Vehicle No": re.search(r"Registration No\.?\s*[:]?([\w\d-]+)", text, re.IGNORECASE),
        "Engine No": re.search(r"Engine No\.?\s*/?\s*Motor No\.?\s*\(for EV\)\s*[:]?([\w\d]+)", text, re.IGNORECASE),
        "Chassis No": re.search(r"Chassis No\.?\s*[:]?([\w\d]+)", text, re.IGNORECASE),
        "Total Premium": re.search(r"Total Policy Premium\s*₹?\s*([\d,]+)", text, re.IGNORECASE),
    }

    return {key: match.group(1).strip() if match else "Not Found" for key, match in data.items()}

@app.route("/extract", methods=["POST"])
def extract():
    if "pdf" not in request.files:
        return jsonify({"error": "No file uploaded"}), 400

    pdf = request.files["pdf"]
    pdf_path = "temp.pdf"
    pdf.save(pdf_path)

    data = extract_policy_details(pdf_path)
    return jsonify(data)

if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5000)
