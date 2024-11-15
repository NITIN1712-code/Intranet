<section class="leave-request-section">
                <h2>Leave Request Form</h2>
                <form action="process_leave_requests.php" method="POST" onsubmit= "return validateForm();">
                    <div class="form-group">
                        <label for="employee_id">Employee ID:</label>
                        <input type="text" id="employee_id" name="employee_id" required>
                    </div>
                    <div class="form-group">
                        <label for="leaveDate">Leave Date:</label>
                        <input type="date" id="leaveDate" name="leaveDate" required>
                    </div>
                    <div class="form-group">
                        <label for="leaveType">Leave Type:</label>
                        <select id="leaveType" name="leaveType" required>
                            <option value="Sick Leave">Sick Leave</option>
                            <option value="Casual Leave">Casual Leave</option>
                            <option value="Annual Leave">Annual Leave</option>
                        </select>
                    </div>
                    <button type="submit" class="submit-button">Submit Leave Request</button>
                </form>
            </section>