import mysql.connector
import openai

# Connect to MySQL
db = mysql.connector.connect(
    host="your_host",
    user="your_username",
    password="your_password",
    database="your_database"
)
cursor = db.cursor()

# Fetch unmoderated comments
cursor.execute("SELECT id, body FROM comments WHERE status = 'unreviewed'")
comments = cursor.fetchall()

# Initialize OpenAI API
openai.api_key = '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'

# Moderate comments
for comment_id, content in comments:
    response = openai.Moderation.create(
        input=content
    )
    # Assume 'response' includes a moderation result you can act on
    # Update the comment based on the moderation result
    # This is a simplified example; you'll need to adapt it based on actual API responses
    if response['flagged']:
        update_query = "UPDATE comments SET status = 'flagged' WHERE id = %s"
    else:
        update_query = "UPDATE comments SET status = 'approved' WHERE id = %s"
    cursor.execute(update_query, (comment_id,))
    db.commit()

# Close the database connection
cursor.close()
db.close()
