from flask import Flask, render_template, request, redirect, url_for, send_file
import sqlite3
import csv
import io

app = Flask(__name__)

# Create database and table if not exists
def init_db():
    conn = sqlite3.connect('contact.db')
    c = conn.cursor()
    c.execute('''CREATE TABLE IF NOT EXISTS contacts (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name TEXT,
                    email TEXT,
                    message TEXT
                )''')
    conn.commit()
    conn.close()

init_db()

@app.route('/')
def contact():
    return render_template('contact.html')

@app.route('/submit', methods=['POST'])
def submit():
    name = request.form['name']
    email = request.form['email']
    message = request.form['message']

    conn = sqlite3.connect('contact.db')
    c = conn.cursor()
    c.execute("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)", (name, email, message))
    conn.commit()
    conn.close()

    return redirect('/view')

@app.route('/view')
def view():
    conn = sqlite3.connect('contact.db')
    c = conn.cursor()
    c.execute("SELECT * FROM contacts")
    data = c.fetchall()
    conn.close()
    return render_template('view.html', data=data)

@app.route('/delete/<int:id>')
def delete(id):
    conn = sqlite3.connect('contact.db')
    c = conn.cursor()
    c.execute("DELETE FROM contacts WHERE id = ?", (id,))
    conn.commit()
    conn.close()
    return redirect(url_for('view'))

@app.route('/export')
def export():
    conn = sqlite3.connect('contact.db')
    c = conn.cursor()
    c.execute("SELECT * FROM contacts")
    data = c.fetchall()
    conn.close()

    # Convert to CSV in memory
    output = io.StringIO()
    writer = csv.writer(output)
    writer.writerow(['ID', 'Name', 'Email', 'Message'])
    writer.writerows(data)

    output.seek(0)
    return send_file(io.BytesIO(output.getvalue().encode()), mimetype='text/csv',
                     as_attachment=True, download_name='contact_data.csv')

if __name__ == '__main__':
    app.run(debug=True)

